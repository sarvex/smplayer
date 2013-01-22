all: es.po nl.po fr.po ja.po pl.po ro.po uk.po ru.po hu.po zh.po de.po pt.po it.po fi.po lt.po eu.po gl.po ca.po

FILES= ../index.php ../config.php ../inc/features.php \
       ../inc/header.php ../inc/footer.php ../downloads.php \
       ../screenshots.php ../latest.php ../formats.php \
       ../inc/formats_text.php ../smtube.php ../contact.php ../faq.php \
       ../reviews.php ../presskit.php ../inc/reviews_box.php \
       ../inc/gallery.php ../smplayer.php ../umplayer.php

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

pl.po: empty.pot
	msgmerge -F -U -N --backup=numbered pl.po empty.pot

ro.po: empty.pot
	msgmerge -F -U -N --backup=numbered ro.po empty.pot

uk.po: empty.pot
	msgmerge -F -U -N --backup=numbered uk.po empty.pot

ru.po: empty.pot
	msgmerge -F -U -N --backup=numbered ru.po empty.pot

hu.po: empty.pot
	msgmerge -F -U -N --backup=numbered hu.po empty.pot

zh.po: empty.pot
	msgmerge -F -U -N --backup=numbered zh.po empty.pot

de.po: empty.pot
	msgmerge -F -U -N --backup=numbered de.po empty.pot

pt.po: empty.pot
	msgmerge -F -U -N --backup=numbered pt.po empty.pot

it.po: empty.pot
	msgmerge -F -U -N --backup=numbered it.po empty.pot

fi.po: empty.pot
	msgmerge -F -U -N --backup=numbered fi.po empty.pot

lt.po: empty.pot
	msgmerge -F -U -N --backup=numbered lt.po empty.pot

eu.po: empty.pot
	msgmerge -F -U -N --backup=numbered eu.po empty.pot

gl.po: empty.pot
	msgmerge -F -U -N --backup=numbered gl.po empty.pot

ca.po: empty.pot
	msgmerge -F -U -N --backup=numbered ca.po empty.pot

clean:
	-rm *~
