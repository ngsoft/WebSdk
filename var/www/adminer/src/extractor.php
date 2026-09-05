<?php

return function ($archive, $app)
{
    if ( ! is_file($app))
    {
        $zip_file = basename($archive);

        if ( ! is_file($archive))
        {
            throw new \RuntimeException("Archive {$zip_file} not found");
        }

        $zip      = new \ZipArchive();

        if (true !== $zip->open($archive))
        {
            throw new \RuntimeException("Cannot open archive: {$zip_file}");
        }
        $entry    = basename($app);
        $contents = $zip->getFromName($entry);
        $zip->close();

        if (false === $contents)
        {
            throw new \RuntimeException("Missing {$entry} in archive: {$zip_file}");
        }

        if (false === file_put_contents($app, $contents))
        {
            throw new \RuntimeException("Cannot write: {$entry}");
        }
    }
};
