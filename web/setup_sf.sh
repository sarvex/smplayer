#!/bin/sh

# Create symlinks
ln -sf /tmp/persistent/smplayer/cache/ forums/cache
ln -sf /tmp/persistent/smplayer/avatars forums/img/avatars

# Create .htaccess
#echo 'php_value session.save_path "/tmp/persistent/smplayer/sessions"' > .htaccess
#echo 'php_value session.save_handler "files"' >> .htaccess

# Create site.php
echo '<?php $site = "sourceforge"; ?>' > site.php

