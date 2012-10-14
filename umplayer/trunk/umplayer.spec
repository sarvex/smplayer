# norootforbuild

%define kdedir			/opt/kde3
%define qtdir			%{_usr}

%bcond_with kde

Name:			umplayer
Version:		1.0
Release:		1
Summary:		Complete Frontend for MPlayer
Source:			http://prdownloads.sourceforge.net/umplayer/umplayer-%{version}.tar.bz2
URL:			http://umplayer.sourceforge.net/
Group:			Productivity/Multimedia/Video/Players
License:		GNU General Public License version 2 or later (GPL v2 or later)
BuildRoot:		%{_tmppath}/build-%{name}-%{version}
BuildRequires:		libqt4-devel >= 4.6.3
#%if %{with kde}
#BuildRequires:	kdelibs3-devel
#%endif
BuildRequires:	gcc-c++ libstdc++-devel make update-desktop-files
BuildRequires:  subversion tar
BuildRequires:  hicolor-icon-theme
Requires:		mplayer xdg-utils
Suggests:		umplayer-themes
Conflicts:		umplayer-old
Obsoletes:		umplayer-beta < %{version}
Provides:		umplayer-beta = %{version}-%{release}
BuildRequires:  licenses
Requires:       licenses

%description
UMPlayer intends to be a complete front-end for MPlayer, from basic features
like playing videos, DVDs, and VCDs to more advanced features like support for
MPlayer filters and more.

One of the most interesting features of UMPlayer: it remembers the settings of
all files you play. So you start to watch a movie but you have to leave...
don't worry, when you open that movie again it will resume at the same point
you left it, and with the same settings: audio track, subtitles, volume...




Authors:
--------
    Vinay Khaitan <vkhaitan@gmail.com>

%lang_package
%debug_package
%prep
%setup -q -n "umplayer-%{version}"

# fix CRLF in .txt files:
%__sed -i 's/\r$//' *.txt

%build
export PATH="%{qtdir}/bin:$PATH"
%__make \
	MAKEFLAGS="%{?jobs:-j%{jobs}}" \
	CONF_PREFIX="" \
	PREFIX="%{_prefix}" \
	KDE_PREFIX="%{_prefix}" \
	DOC_PATH="%{_docdir}/%{name}" \
%if %{with kde}
	KDE_SUPPORT=1 \
	KDE_INCLUDE_PATH="%{kdedir}/include" \
	KDE_LIB_PATH="%{kdedir}/%{_lib}"
%endif

%install
export PATH="%{qtdir}/bin:$PATH"
%__make \
	MAKEFLAGS="" \
	CONF_PREFIX="%{buildroot}" \
	PREFIX="%{buildroot}%{_prefix}" \
	KDE_PREFIX="%{buildroot}%{_prefix}" \
	DOC_PATH="%{buildroot}%{_docdir}/%{name}" \
%if %{with kde}
	KDE_SUPPORT=1 \
	KDE_INCLUDE_PATH="%{kdedir}/include" \
	KDE_LIB_PATH="%{kdedir}/%{_lib}" \
%endif
	install

%__rm -rf "%{buildroot}%{_docdir}/%{name}"

%if %{defined suse_version}
    for desktop in umplayer umplayer_enqueue; do
	%suse_update_desktop_file -r "$desktop"
    done
%else
    xdg-desktop-menu install "$desktop" --novendor
%endif
    xdg-icon-resource forceupdate --theme hicolor

LANGFILE="$PWD/umplayer.lang"
echo -n > "$LANGFILE"
find "%{buildroot}%{_datadir}/umplayer/translations" -name '*.qm' \
| while read qm; do
	qmfile=${qm##*/}
	l=${qmfile##*_}
	l=${l%%.qm}

    [ "$l" = "en_US" ] && continue    
	echo "%lang(${l}) %{_datadir}/umplayer/translations/${qmfile}" >> "$LANGFILE"
done
%__install -d "%{buildroot}%{_docdir}/%{name}"
pushd docs
for l in *; do
    %__cp -a "$l" "%{buildroot}%{_docdir}/%{name}/${l}"

    [ "$l" = "en" ] && continue
    echo "%lang(${l}) %{_docdir}/%{name}/${l}" >> "$LANGFILE"
done
popd #docs

%__install -m0644 Changelog *.txt "%{buildroot}%{_docdir}/%{name}"/

# we know this is the GPL 2.0
%__ln_s -f $(readlink -f /usr/share/doc/licenses/GPL-2.0.txt) Copying.txt

%clean
%__rm -rf "%{buildroot}"

%files
%defattr(-,root,root)
%doc %dir %{_docdir}/%{name}
%doc %{_docdir}/%{name}/Changelog
%doc %{_docdir}/%{name}/*.txt
%doc %{_docdir}/%{name}/en
%{_bindir}/umplayer
%{_datadir}/applications/umplayer.desktop
%{_datadir}/applications/umplayer_enqueue.desktop
%{_datadir}/icons/*/*/apps/umplayer.*
%{_datadir}/umplayer/themes
%dir %{_datadir}/umplayer
%config %{_datadir}/umplayer/input.conf
%dir %{_datadir}/umplayer/shortcuts
%{_datadir}/umplayer/shortcuts/*.keys
%dir %{_datadir}/umplayer/translations
%doc %{_mandir}/man1/umplayer.1%{ext_man}
%lang(en_US) %{_datadir}/umplayer/translations/umplayer_en_US.qm


%files lang -f %{name}.lang
%defattr(-,root,root)

%changelog
* Wed Nov 17 2010 vkhaitan
   Initial beta Version
