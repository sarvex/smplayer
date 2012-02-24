
PREFIX=/usr/local
#PREFIX=/tmp/smplayer

CONF_PREFIX=$(PREFIX)

DATA_PATH=$(PREFIX)/share/smplayer-yt-browser
DOC_PATH=$(PREFIX)/share/doc/packages/smplayer-yt-browser
TRANSLATION_PATH=$(PREFIX)/share/smplayer-yt-browser/translations

KDE_PREFIX=$(PREFIX)
KDE_ICONS=$(KDE_PREFIX)/share/icons/hicolor/
KDE_APPLNK=$(KDE_PREFIX)/share/applications/

QMAKE=qmake
LRELEASE=lrelease

DEFS=DATA_PATH=\\\"$(DATA_PATH)\\\" \
     TRANSLATION_PATH=\\\"$(TRANSLATION_PATH)\\\" \
     DOC_PATH=\\\"$(DOC_PATH)\\\"

src/smplayer-yt-browser:
#	./get_svn_revision.sh
	+cd src && $(QMAKE) $(QMAKE_OPTS) && $(DEFS) make
	cd src && $(LRELEASE) smplayer-yt-browser.pro

clean:
	if [ -f src/Makefile ]; then cd src && make distclean; fi
	-rm src/translations/smplayer-yt-browser_*.qm

install: src/smplayer-yt-browser
	-install -d $(DESTDIR)$(PREFIX)/bin/
	install -m 755 src/smplayer-yt-browser $(DESTDIR)$(PREFIX)/bin/
	-install -d $(DESTDIR)$(DATA_PATH)
	-install -d $(DESTDIR)$(TRANSLATION_PATH)
	install -m 644 src/translations/*.qm $(DESTDIR)$(TRANSLATION_PATH)
	-install -d $(DESTDIR)$(DOC_PATH)
	install -m 644 Changelog *.txt $(DESTDIR)$(DOC_PATH)

#	-install -d $(DESTDIR)$(KDE_ICONS)/64x64/apps/
#	-install -d $(DESTDIR)$(KDE_ICONS)/32x32/apps/
#	-install -d $(DESTDIR)$(KDE_ICONS)/22x22/apps/
#	-install -d $(DESTDIR)$(KDE_ICONS)/16x16/apps/
#	install -m 644 icons/smplayer_icon64.png $(DESTDIR)$(KDE_ICONS)/64x64/apps/smplayer.png
#	install -m 644 icons/smplayer_icon32.png $(DESTDIR)$(KDE_ICONS)/32x32/apps/smplayer.png
#	install -m 644 icons/smplayer_icon22.png $(DESTDIR)$(KDE_ICONS)/22x22/apps/smplayer.png
#	install -m 644 icons/smplayer_icon16.png $(DESTDIR)$(KDE_ICONS)/16x16/apps/smplayer.png
#	-install -d $(DESTDIR)$(KDE_APPLNK)
#	install -m 644 smplayer-yt-browser.desktop $(DESTDIR)$(KDE_APPLNK)
#	-install -d $(DESTDIR)$(PREFIX)/share/man/man1/
#	install -m 644 man/smplayer-yt-browser.1 $(DESTDIR)$(PREFIX)/share/man/man1/
#	gzip -9 -f $(DESTDIR)$(PREFIX)/share/man/man1/smplayer-yt-browser.1

uninstall:
	-rm -f $(PREFIX)/bin/smplayer-yt-browser
	-rm -f $(TRANSLATION_PATH)/*.qm
	-rm -f $(DOC_PATH)/Changelog
	-rm -f $(DOC_PATH)/*.txt
#	-rm -f $(KDE_ICONS)/64x64/apps/smplayer.png
#	-rm -f $(KDE_ICONS)/32x32/apps/smplayer.png
#	-rm -f $(KDE_ICONS)/22x22/apps/smplayer.png
#	-rm -f $(KDE_ICONS)/16x16/apps/smplayer.png
#	-rm -f $(KDE_APPLNK)/smplayer-yt-browser.desktop
#	-rm -f $(PREFIX)/share/man/man1/smplayer-bt-browser.1.gz
	-rmdir $(TRANSLATION_PATH)/

