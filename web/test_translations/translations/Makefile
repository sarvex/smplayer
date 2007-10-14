all: es.po

FILES=../index.php ../page2.php

empty.pot: $(FILES)
	xgettext --add-comments \
             --output=empty.pot --keyword=tr --language=PHP \
             --from-code=ISO-8859-1 $(FILES)

es.po: empty.pot
	msgmerge -F -U -N --backup=numbered es.po empty.pot

