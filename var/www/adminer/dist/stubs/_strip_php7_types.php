<?php
/**
 * Strip PHP 7+ native types from stubs; keep/add PHPDoc. Target: PHP 5.6 syntax.
 * Keeps PHP 5-safe hints: array, class/FQCN. Nullable class/array with `= null` kept without `?`.
 *
 * Usage: php dist/stubs/_strip_php7_types.php
 */
$root = __DIR__;

$PHP7 = array(
	'string' => 1, 'int' => 1, 'integer' => 1, 'bool' => 1, 'boolean' => 1,
	'float' => 1, 'double' => 1, 'void' => 1, 'iterable' => 1, 'object' => 1, 'mixed' => 1,
);

function is_ws($t)
{
	return is_array($t) && $t[0] === T_WHITESPACE;
}

function is_amp($t)
{
	if ($t === '&') {
		return true;
	}
	if (!is_array($t)) {
		return false;
	}
	return in_array($t[0], array(
		T_AMPERSAND_FOLLOWED_BY_VAR_OR_VARARG,
		T_AMPERSAND_NOT_FOLLOWED_BY_VAR_OR_VARARG,
	), true);
}

function tok_text($t)
{
	return is_array($t) ? $t[1] : $t;
}

function normalize_doc_type($type)
{
	$type = ltrim($type, '\\');
	if (stripos($type, 'Adminer\\') === 0) {
		$type = substr($type, 8);
	}
	$map = array('integer' => 'int', 'boolean' => 'bool', 'double' => 'float');
	$l = strtolower($type);
	return isset($map[$l]) ? $map[$l] : $type;
}

function doc_type($type, $nullable)
{
	$t = normalize_doc_type($type);
	return $nullable ? $t . '|null' : $t;
}

function is_php7_scalar($type, $PHP7)
{
	return isset($PHP7[strtolower(ltrim($type, '\\'))]);
}

function doc_has_tag($doc, $tag, $var = null)
{
	if ($var !== null) {
		$name = ltrim($var, '$');
		return (bool) preg_match('/@' . preg_quote($tag, '/') . '\s+\S[^\n]*\$' . preg_quote($name, '/') . '\b/', $doc);
	}
	return (bool) preg_match('/@' . preg_quote($tag, '/') . '\b/', $doc);
}

/**
 * Merge @param/@return/@var into the nearest preceding docblock, preserving its "*" indent.
 *
 * @param string   $preceding
 * @param string[] $lines
 * @return string
 */
function merge_phpdoc($preceding, array $lines)
{
	$lines = array_values(array_filter($lines));
	if (!$lines) {
		return $preceding;
	}

	if (preg_match('/^(.*)(\/\*\*.*?\*\/)(\s*)\z/s', $preceding, $m)) {
		$before = $m[1];
		$doc = $m[2];
		$after = $m[3];

		// Indent of the docblock (tabs before /** live in $before, not inside $doc)
		$docIndent = '';
		if (preg_match('/([ \t]+)\z/', $before, $im)) {
			$docIndent = $im[1];
		}

		// Detect star indent from an existing line, e.g. "\t *" or " *"
		$starIndent = $docIndent . ' *';
		if (preg_match('/\n([ \t]*)\*/', $doc, $im)) {
			$starIndent = $im[1] . '*';
		}

		$add = array();
		foreach ($lines as $line) {
			if (preg_match('/^@param\s+\S+\s+(\$\w+)/', $line, $pm)) {
				if (doc_has_tag($doc, 'param', $pm[1])) {
					continue;
				}
			} elseif (preg_match('/^@return\b/', $line)) {
				if (doc_has_tag($doc, 'return')) {
					continue;
				}
			} elseif (preg_match('/^@var\b/', $line)) {
				if (doc_has_tag($doc, 'var')) {
					continue;
				}
			}
			$add[] = $line;
		}
		if (!$add) {
			return $preceding;
		}

		$doc = preg_replace('/\s*\*\/\s*$/', "\n", $doc);
		// Insert @param before existing @return when possible
		$params = array();
		$others = array();
		foreach ($add as $line) {
			if (preg_match('/^@param\b/', $line)) {
				$params[] = $line;
			} else {
				$others[] = $line;
			}
		}
		if ($params && preg_match('/^((?:.*\n)*)([ \t]*\*[ \t]*@return\b.*\n?)/s', $doc, $rm)) {
			$insert = '';
			foreach ($params as $line) {
				$insert .= $starIndent . ' ' . $line . "\n";
			}
			$doc = $rm[1] . $insert . $rm[2];
			$params = array();
		}
		foreach (array_merge($params, $others) as $line) {
			$doc .= $starIndent . ' ' . $line . "\n";
		}
		// closing */ with same indent as stars (without the *)
		$closeIndent = (strlen($starIndent) > 1) ? substr($starIndent, 0, -1) : '';
		$doc .= $closeIndent . '*/';
		return $before . $doc . $after;
	}

	// New docblock: consume trailing spaces/tabs only (\z, not $ — PHP $ matches before final newline).
	// Default indent '' (file-level functions); class methods pass their leading tab via trailing ws.
	$indent = '';
	if (preg_match('/^(.*?)([ \t]+)\z/s', $preceding, $im)) {
		$preceding = $im[1];
		$indent = $im[2];
	}
	$block = $indent . "/**\n";
	foreach ($lines as $line) {
		$block .= $indent . ' * ' . $line . "\n";
	}
	$block .= $indent . " */\n" . $indent;
	return $preceding . $block;
}

function parse_type(array $tokens, &$i, $n)
{
	$nullable = false;
	while ($i < $n && is_ws($tokens[$i])) {
		$i++;
	}
	if ($i < $n && $tokens[$i] === '?') {
		$nullable = true;
		$i++;
		while ($i < $n && is_ws($tokens[$i])) {
			$i++;
		}
	}
	$type = '';
	while ($i < $n) {
		$t = $tokens[$i];
		if (!is_array($t)) {
			if ($t === '\\') {
				$type .= '\\';
				$i++;
				continue;
			}
			break;
		}
		$id = $t[0];
		if ($id === T_STRING || $id === T_NS_SEPARATOR || $id === T_ARRAY
			|| (defined('T_NAME_QUALIFIED') && $id === T_NAME_QUALIFIED)
			|| (defined('T_NAME_FULLY_QUALIFIED') && $id === T_NAME_FULLY_QUALIFIED)
			|| (defined('T_NAME_RELATIVE') && $id === T_NAME_RELATIVE)
		) {
			$type .= ($id === T_ARRAY) ? 'array' : $t[1];
			$i++;
			continue;
		}
		break;
	}
	return array($type, $nullable);
}

function guess_indent($text)
{
	if (preg_match('/(?:^|\n)([ \t]*)$/', $text, $m) && $m[1] !== '') {
		return $m[1];
	}
	return "\t";
}

function patch_docs_before_function($out, $funcStartOutLen, array $extra)
{
	$beforeFunc = substr($out, 0, $funcStartOutLen);
	$fromFunc = substr($out, $funcStartOutLen);
	if (preg_match('/^(.*?)((?:(?:public|protected|private|static|final|abstract)\s+)+)$/s', $beforeFunc, $m)) {
		$beforeFunc = $m[1];
		$fromFunc = $m[2] . $fromFunc;
	}
	return merge_phpdoc($beforeFunc, $extra) . $fromFunc;
}

function transform_file($path, array $PHP7)
{
	$tokens = token_get_all(file_get_contents($path));
	$n = count($tokens);
	$out = '';
	$i = 0;

	while ($i < $n) {
		$t = $tokens[$i];

		// Typed properties
		if (is_array($t) && in_array($t[0], array(T_PUBLIC, T_PROTECTED, T_PRIVATE), true)) {
			$start = $i;
			$vis = '';
			while ($i < $n) {
				$u = $tokens[$i];
				if (is_array($u) && in_array($u[0], array(T_PUBLIC, T_PROTECTED, T_PRIVATE, T_STATIC, T_WHITESPACE), true)) {
					$vis .= $u[1];
					$i++;
					continue;
				}
				break;
			}
			$ti = $i;
			list($ptype, $pnull) = parse_type($tokens, $ti, $n);
			while ($ti < $n && is_ws($tokens[$ti])) {
				$ti++;
			}
			if ($ptype !== '' && $ti < $n && is_array($tokens[$ti]) && $tokens[$ti][0] === T_VARIABLE) {
				$out = merge_phpdoc($out, array('@var ' . doc_type($ptype, $pnull)));
				$out .= rtrim($vis) . ' ';
				$i = $ti;
				continue;
			}
			$i = $start;
			$out .= tok_text($tokens[$i]);
			$i++;
			continue;
		}

		if (is_array($t) && $t[0] === T_FUNCTION) {
			$funcStartOutLen = strlen($out);
			$out .= $t[1];
			$i++;

			// optional whitespace, returning-by-ref amp, name
			while ($i < $n) {
				$u = $tokens[$i];
				if (is_ws($u)) {
					$out .= $u[1];
					$i++;
					continue;
				}
				if (is_amp($u)) {
					$out .= '&';
					$i++;
					continue;
				}
				if (is_array($u) && $u[0] === T_STRING) {
					$out .= $u[1];
					$i++;
					continue;
				}
				break;
			}
			if ($i >= $n || $tokens[$i] !== '(') {
				continue;
			}
			$out .= '(';
			$i++;

			$paramDocs = array();
			while ($i < $n && $tokens[$i] !== ')') {
				if ($tokens[$i] === ',') {
					$out .= ',';
					$i++;
					continue;
				}
				if (is_ws($tokens[$i])) {
					$out .= $tokens[$i][1];
					$i++;
					continue;
				}

				$beforeParam = $i;
				list($ptype, $pnull) = parse_type($tokens, $i, $n);
				$ws = '';
				while ($i < $n && is_ws($tokens[$i])) {
					$ws .= $tokens[$i][1];
					$i++;
				}

				$prefix = '';
				if ($i < $n && is_array($tokens[$i]) && $tokens[$i][0] === T_ELLIPSIS) {
					$prefix .= '...';
					$i++;
					while ($i < $n && is_ws($tokens[$i])) {
						$prefix .= $tokens[$i][1];
						$i++;
					}
				}
				if ($i < $n && is_amp($tokens[$i])) {
					$prefix .= '&';
					$i++;
					while ($i < $n && is_ws($tokens[$i])) {
						$prefix .= $tokens[$i][1];
						$i++;
					}
				}

				if ($i < $n && is_array($tokens[$i]) && $tokens[$i][0] === T_VARIABLE) {
					$var = $tokens[$i][1];
					$i++;

					$default = '';
					$di = $i;
					while ($di < $n && $tokens[$di] !== ',' && $tokens[$di] !== ')') {
						$default .= tok_text($tokens[$di]);
						$di++;
					}

					if ($ptype !== '') {
						$paramDocs[] = '@param ' . doc_type($ptype, $pnull) . ' ' . $var;
						$keep = false;
						if (!$pnull && !is_php7_scalar($ptype, $PHP7)) {
							$keep = true; // array / class
						} elseif ($pnull && !is_php7_scalar($ptype, $PHP7) && preg_match('/^\s*=\s*null\b/i', $default)) {
							$keep = true; // Class $x = null (PHP 5 OK)
						}
						if ($keep) {
							$out .= $ptype . ($ws !== '' ? $ws : ' ');
						}
					}
					$out .= $prefix . $var;
					while ($i < $n && $tokens[$i] !== ',' && $tokens[$i] !== ')') {
						$out .= tok_text($tokens[$i]);
						$i++;
					}
					continue;
				}

				$i = $beforeParam;
				$out .= tok_text($tokens[$i]);
				$i++;
			}

			if ($i < $n && $tokens[$i] === ')') {
				$out .= ')';
				$i++;
			}

			$returnDoc = null;
			$wsRet = '';
			while ($i < $n && is_ws($tokens[$i])) {
				$wsRet .= $tokens[$i][1];
				$i++;
			}
			if ($i < $n && $tokens[$i] === ':') {
				$i++;
				while ($i < $n && is_ws($tokens[$i])) {
					$i++;
				}
				list($rtype, $rnull) = parse_type($tokens, $i, $n);
				if ($rtype !== '') {
					$returnDoc = '@return ' . doc_type($rtype, $rnull);
				}
				while ($i < $n && is_ws($tokens[$i])) {
					$i++;
				}
				// Keep a space before "{" when return type was on the same line
				if ($i < $n && $tokens[$i] === '{' && strpos($wsRet, "\n") === false) {
					$out .= ' ';
				} elseif (strpos($wsRet, "\n") !== false) {
					$out .= $wsRet;
				} elseif ($i < $n && $tokens[$i] === '{') {
					$out .= ' ';
				} elseif ($i < $n && $tokens[$i] === ';') {
					// abstract method ending with ;
				}
			} else {
				$out .= $wsRet;
			}

			$extra = $paramDocs;
			if ($returnDoc) {
				$extra[] = $returnDoc;
			}
			if ($extra) {
				$out = patch_docs_before_function($out, $funcStartOutLen, $extra);
			}
			continue;
		}

		$out .= tok_text($t);
		$i++;
	}

	return $out;
}

// ---- main ----
$changed = 0;
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS));
foreach ($it as $file) {
	if (!$file->isFile() || strtolower($file->getExtension()) !== 'php') {
		continue;
	}
	$path = $file->getPathname();
	if (basename($path) === '_strip_php7_types.php') {
		continue;
	}
	$orig = file_get_contents($path);
	$new = transform_file($path, $PHP7);
	// PhpStorm: keep file-level inspection suppression (lost when regenerating from typed upstream stubs)
	if (strpos($new, '@noinspection') === false && preg_match('/^<\?php\s*\n/', $new)) {
		$new = preg_replace('/^<\?php\s*\n/', "<?php\n/** @noinspection ALL */\n\n", $new, 1);
	}
	if ($new !== $orig) {
		file_put_contents($path, $new);
		$changed++;
		echo 'updated: ' . substr($path, strlen($root) + 1) . "\n";
	}
}
echo "Done. Files changed: $changed\n";
