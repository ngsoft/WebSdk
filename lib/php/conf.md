```
memory_limit = 256M
post_max_size = 48M
upload_tmp_dir = "C:\WebSdk\tmp"
upload_tmp_dir = ".\..\..\tmp"
upload_max_filesize = 40M


extension_dir = ".\ext"

extension=bz2
extension=curl
extension=fileinfo
extension=gd2
extension=gettext
extension=intl
extension=mbstring
extension=exif 
extension=mysqli
extension=openssl
extension=pdo_mysql
extension=pdo_sqlite
extension=sqlite3

asp_tags=Off
display_startup_errors=On
track_errors=Off
y2k_compliance=On
allow_call_time_pass_reference=Off
safe_mode=Off
safe_mode_gid=Off
safe_mode_allowed_env_vars=PHP_
safe_mode_protected_env_vars=LD_LIBRARY_PATH
error_log=".\logs\php_error_log"
register_globals=Off
register_long_arrays=Off
magic_quotes_gpc=Off
magic_quotes_runtime=Off
magic_quotes_sybase=Off

[Pdo_mysql]
pdo_mysql.default_socket="MySQL"


[Session]
session.save_path = ".\..\..\tmp"


[curl]
; wget https://curl.haxx.se/ca/cacert.pem
curl.cainfo = ".\..\certs\cacert.pem"

[openssl]
openssl.cafile = ".\..\certs\cacert.pem"

; only when available
;[ast]
;extension=ast

[apcu]
extension=apcu
apc.enabled=1
apc.shm_size=512M
apc.ttl=3600
apc.enable_cli=1
apc.serializer=php

[opcache]
; disable in dev mode, enable in prod
; zend_extension=opcache
; php >= 8.1
; opcache.jit=tracing 
opcache.enable=1
opcache.enable_cli=1
opcache.memory_consumption=192
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000
opcache.max_wasted_percentage=10
opcache.revalidate_freq=0
opcache.validate_timestamps=1
opcache.fast_shutdown=1
```
