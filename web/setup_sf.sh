#!/bin/sh

# Create symlinks
ln -sf /tmp/persistent/smplayer/cache/ forums/cache
ln -sf /tmp/persistent/smplayer/avatars forums/img/avatars

# Create .htaccess
echo 'php_value session.save_path "/tmp/persistent/smplayer/sessions"' > .htaccess
echo 'php_value session.save_handler "files"' >> .htaccess

# Create site_logo.html
echo '<a href="http://sourceforge.net"><img src="http://sflogo.sourceforge.net/sflogo.php?group_id=185512&amp;type=2" width="125" height="37" border="0" alt="SourceForge.net Logo" /></a>' > site_logo.html

