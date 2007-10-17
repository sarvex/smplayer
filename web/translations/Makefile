all: es.po nl.po fr.po ja.po

FILES=../index.php ../info.php ../header.php ../downloads.php \
      ../documentation.php ../screenshots.php

empty.pot: $(FILES)
	xgettext --add-comments \
             --output=empty.pot --keyword=tr --keyword=get_tr --language=PHP \
             --from-code=ISO-8859-1 $(FILES)

es.po: empty.pot
	msgmerge -F -U -N --backup=numbered es.po empty.pot

nl.po: empty.pot
	msgmerge -F -U -N --backup=numbered nl.po empty.pot

fr.po: empty.pot
	msgmerge -F -U -N --backup=numbered fr.po empty.pot

ja.po: empty.pot
	msgmerge -F -U -N --backup=numbered ja.po empty.pot

