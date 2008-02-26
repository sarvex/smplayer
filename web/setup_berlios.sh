#!/bin/sh

# Create folders
mkdir forums/cache
chmod 777 forums/cache
mkdir forums/img/avatars
chmod 777 forums/img/avatars

# Create site.php
echo '<?php $site = "berlios"; ?>' > site.php

