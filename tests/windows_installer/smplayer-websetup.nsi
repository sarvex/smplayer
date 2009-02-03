; NSIS script created by redxii for RVM's SMPlayer
;--------------------------------
;Compressor

  SetCompressor /SOLID lzma
  SetCompressorDictSize 32

;--------------------------------
;Additional plugin folders

  !addplugindir plugins

;--------------------------------
;Defines & includes

!define PRODUCT_NAME "SMPlayer"
!define PRODUCT_VERSION "0.6.7"
!define PRODUCT_PUBLISHER "RVM"
!define PRODUCT_WEB_SITE "http://smplayer.sf.net"
!define PRODUCT_FORUM "http://smplayer.sourceforge.net/forums"
!define PRODUCT_UNINST_KEY "Software\Microsoft\Windows\CurrentVersion\Uninstall\${PRODUCT_NAME}"
!define PRODUCT_UNINST_ROOT_KEY "HKLM"
!define PRODUCT_STARTMENU_GROUP "SMPlayer"
!define CODEC_VERSION "windows-essential-20071007"
!define MPLAYER_VERSION "mplayer-svn-28311"

!include MUI2.nsh
!include WinVer.nsh

;--------------------------------
;Configuration

  ;General
  Name "${PRODUCT_NAME} ${PRODUCT_VERSION}"
  OutFile "smplayer_${PRODUCT_VERSION}_websetup.exe"
  
  ;Version tab properties
  VIProductVersion "${PRODUCT_VERSION}.0"
  VIAddVersionKey "ProductName" "SMPlayer"
  VIAddVersionKey "Comments" "This installation was built with NSIS."
  VIAddVersionKey "LegalTrademarks" "RVM"
  VIAddVersionKey "LegalCopyright" "RVM"
  VIAddVersionKey "CompanyName" "RVM"
  VIAddVersionKey "FileDescription" "SMPlayer for Windows"
  VIAddVersionKey "FileVersion" "${PRODUCT_VERSION}"
  
  ;Default installation page stored to $INSTDIR
  InstallDir "$PROGRAMFILES\SMPlayer"

  ;Put on a show
  ShowInstDetails show
  ShowUnInstDetails show

;--------------------------------
;Variables

;--------------------------------
;Interface Settings

  !define MUI_ABORTWARNING
  !define MUI_COMPONENTSPAGE_SMALLDESC
  !define MUI_LICENSEPAGE_CHECKBOX
  !define MUI_FINISHPAGE_RUN $INSTDIR\smplayer.exe
  !define MUI_FINISHPAGE_RUN_PARAMETERS http://88.191.30.130:8050
  !define MUI_FINISHPAGE_SHOWREADME $INSTDIR\Release_notes.txt
  !define MUI_FINISHPAGE_SHOWREADME_TEXT "View Release Notes"
  !define MUI_WELCOMEFINISHPAGE_BITMAP "${NSISDIR}\Contrib\Graphics\Wizard\orange.bmp"

  # Installer/Uninstaller icons
  !define MUI_ICON "${NSISDIR}\Contrib\Graphics\Icons\orange-install.ico"
  !define MUI_UNICON "${NSISDIR}\Contrib\Graphics\Icons\orange-uninstall.ico"

  # Language Selection Dialog Settings
  !define MUI_LANGDLL_REGISTRY_ROOT "${PRODUCT_UNINST_ROOT_KEY}"
  !define MUI_LANGDLL_REGISTRY_KEY "${PRODUCT_UNINST_KEY}"
  !define MUI_LANGDLL_REGISTRY_VALUENAME "NSIS:Language"

;--------------------------------
;Pages
;MUI_PAGE_WELCOME should always be first and MUI_PAGE_FINISH should be last

  # Install Pages
  !insertmacro MUI_PAGE_WELCOME
  !insertmacro MUI_PAGE_LICENSE "smplayer-build\Copying.txt"
  !insertmacro MUI_PAGE_COMPONENTS
  !insertmacro MUI_PAGE_DIRECTORY
  !insertmacro MUI_PAGE_INSTFILES
  !insertmacro MUI_PAGE_FINISH

  # UnInstall Pages
  !insertmacro MUI_UNPAGE_INSTFILES

;--------------------------------
; Languages

  !insertmacro MUI_LANGUAGE "Basque"
  !insertmacro MUI_LANGUAGE "Catalan"
  !insertmacro MUI_LANGUAGE "Czech"
  !insertmacro MUI_LANGUAGE "Danish"
  !insertmacro MUI_LANGUAGE "Dutch"
  !insertmacro MUI_LANGUAGE "English"
  !insertmacro MUI_LANGUAGE "Finnish"
  !insertmacro MUI_LANGUAGE "French"
  !insertmacro MUI_LANGUAGE "German"
  !insertmacro MUI_LANGUAGE "Hebrew"
  !insertmacro MUI_LANGUAGE "Hungarian"
  !insertmacro MUI_LANGUAGE "Italian"
  !insertmacro MUI_LANGUAGE "Norwegian"
  !insertmacro MUI_LANGUAGE "NorwegianNynorsk"
  !insertmacro MUI_LANGUAGE "Polish"
  !insertmacro MUI_LANGUAGE "Portuguese"
  !insertmacro MUI_LANGUAGE "PortugueseBR"
  !insertmacro MUI_LANGUAGE "Russian"
  !insertmacro MUI_LANGUAGE "Slovak"
  !insertmacro MUI_LANGUAGE "Slovenian"
  !insertmacro MUI_LANGUAGE "Spanish"
  !insertmacro MUI_LANGUAGE "SpanishInternational"

;--------------------------------
;Reserve Files
  
  ;These files should be inserted before other files in the data block
  ;Keep these lines before any File command
  ;Only for solid compression (by default, solid compression is enabled for BZIP2 and LZMA)
  
  !insertmacro MUI_RESERVEFILE_LANGDLL

;--------------------------------
;Installer Types
;First in list is #1, second in list in #2, etc

  InstType "Standard installation"
  InstType "Full installation"

;------------------------------------------------------------------------------------------------
;Installer Sections

;--------------------------------
; Main SMPlayer files
Section SMPlayer SEC01

  SectionIn 1 2 RO
  SetOutPath "$INSTDIR"
  SetOverwrite ifnewer
  File "smplayer-build\*"

  # Docs folder
  SetOutPath "$INSTDIR"
  File /r "smplayer-build\docs"

  # Imageformats folder
  SetOutPath "$INSTDIR"
  File /r "smplayer-build\imageformats"

  # Shortcuts folder
  SetOutPath "$INSTDIR"
  File /r "smplayer-build\shortcuts"

  # UnInstall file
  WriteUninstaller "$INSTDIR\uninst.exe"
  
  # HKEY_CLASSES_ROOT ProgId registration
  WriteRegStr HKCR "MPlayerFileVideo\DefaultIcon" "" '"$INSTDIR\smplayer.exe",1'
  WriteRegStr HKCR "MPlayerFileVideo\shell\enqueue" "" "Enqueue in SMPlayer"
  WriteRegStr HKCR "MPlayerFileVideo\shell\enqueue\command" "" '"$INSTDIR\smplayer.exe" -add-to-playlist "%1"'
  WriteRegStr HKCR "MPlayerFileVideo\shell\open" "FriendlyAppName" "SMPlayer Media Player"
  WriteRegStr HKCR "MPlayerFileVideo\shell\open\command" "" '"$INSTDIR\smplayer.exe" "%1"'

  # Windows Vista+ Default Programs registration
  ${If} ${AtLeastWinVista}
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities" "ApplicationDescription" "SMPlayer is a complete front-end for MPlayer, from basic features like playing videos, DVDs, VCDs to more advanced features like support for MPlayer filters, edl lists, and more."
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities" "ApplicationName" "SMPlayer"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".3gp" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".ac3" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".ape" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".asf" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".avi" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".bin" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".dat" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".divx" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".dv" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".dvr-ms" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".flv" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".iso" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".m1v" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".m2v" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".m4v" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".mkv" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".mov" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".mp3" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".mp4" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".mpeg" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".mpg" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".mpv" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".mqv" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".nsv" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".ogg" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".ogm" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".ra" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".ram" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".rmvb" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".ts" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".vcd" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".vfw" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".vob" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".wav" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".wma" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\Clients\Media\SMPlayer\Capabilities\FileAssociations" ".wmv" "MPlayerFileVideo"
    WriteRegStr HKLM "Software\RegisteredApplications" "SMPlayer" "Software\Clients\Media\SMPlayer\Capabilities"
  ${EndIf}

  # Copy 7zip to installer's temp directory
  SetOutPath "$PLUGINSDIR"
  File 7za.exe

SectionEnd

;--------------------------------
; Program shortcuts
SectionGroup "Program Shortcuts"

;--------------------------------
; Desktop shortcut
  Section Desktop SEC02A
    SectionIn 1 2

    # all = global; current = current user
    SetShellVarContext all
    CreateShortCut "$DESKTOP\SMPlayer.lnk" "$INSTDIR\smplayer.exe"

  SectionEnd

;--------------------------------
; Start menu shortcuts
  Section "Start Menu" SEC02B
    SectionIn 1 2

    # Start menu shortcut creation
    SetShellVarContext all
    CreateDirectory "$SMPROGRAMS\${PRODUCT_STARTMENU_GROUP}"
    CreateShortCut "$SMPROGRAMS\${PRODUCT_STARTMENU_GROUP}\${PRODUCT_NAME}.lnk" "$INSTDIR\smplayer.exe"
    WriteINIStr    "$SMPROGRAMS\${PRODUCT_STARTMENU_GROUP}\SMPlayer on the Web.url" "InternetShortcut" "URL" "${PRODUCT_WEB_SITE}"
    CreateShortCut "$SMPROGRAMS\${PRODUCT_STARTMENU_GROUP}\Uninstall ${PRODUCT_NAME}.lnk" "$INSTDIR\uninst.exe"

  SectionEnd
  
SectionGroupEnd

;--------------------------------
; MPlayer Components
SectionGroup /e "MPlayer Components"

;--------------------------------
; MPlayer
  Section MPlayer SEC03A
    SectionIn 1 2 RO
    AddSize 15300

    DetailPrint "Downloading MPlayer..."
    inetc::get /caption "Downloading MPlayer..." /banner "Downloading ${MPLAYER_VERSION}.7z" \
		"http://downloads.sourceforge.net/smplayer/${MPLAYER_VERSION}.7z?big_mirror=0" \
		"$PLUGINSDIR\${MPLAYER_VERSION}.7z"
	;inetc::get /caption "Downloading MPlayer..." /banner "Downloading ${MPLAYER_VERSION}.7z" \
		"ftp://ftp.berlios.de/pub/smplayer/test/${MPLAYER_VERSION}.7z" \
		"$PLUGINSDIR\${MPLAYER_VERSION}.7z"
    Pop $R0
    StrCmp $R0 OK mplayerdl1
      MessageBox MB_OK "Failed to download mplayer package: $R0.$\nSMPlayer won't be able to play anything without a MPlayer build!"
      Abort
      mplayerdl1:
        # Extract
        nsExec::Exec '"$PLUGINSDIR\7za.exe" x "$PLUGINSDIR\${MPLAYER_VERSION}.7z" -o"$PLUGINSDIR"'

        # Copy
        CreateDirectory "$INSTDIR\mplayer"
        CopyFiles /SILENT "$PLUGINSDIR\${MPLAYER_VERSION}\*" "$INSTDIR\mplayer"

  SectionEnd

;--------------------------------
; Binary codecs
  Section /o "Optional Codecs" SEC03B
    SectionIn 2
    AddSize 22300

    DetailPrint "Downloading MPlayer Codecs..."
    inetc::get /caption "Downloading MPlayer Codecs..." /banner "Downloading ${CODEC_VERSION}.zip" \
		"http://www.mplayerhq.hu/MPlayer/releases/codecs/${CODEC_VERSION}.zip" \
		"$PLUGINSDIR\${CODEC_VERSION}.zip"
	;inetc::get /caption "Downloading MPlayer Codecs..." /banner "Downloading ${CODEC_VERSION}.zip" \
		"ftp://ftp.berlios.de/pub/smplayer/test/${CODEC_VERSION}.zip" \
		"$PLUGINSDIR\${CODEC_VERSION}.zip"
    Pop $R0
    StrCmp $R0 OK codecdl1
      MessageBox MB_OK "Failed to download codec package: $R0.$\nCodec installation will be skipped."
      codecdl1:
        # Extract
        nsExec::Exec '"$PLUGINSDIR\7za.exe" x "$PLUGINSDIR\${CODEC_VERSION}.zip" -o"$PLUGINSDIR"'

        # Copy
        CreateDirectory "$INSTDIR\mplayer\codecs"
        CopyFiles /SILENT "$PLUGINSDIR\${CODEC_VERSION}\*" "$INSTDIR\mplayer\codecs"

	SectionEnd

SectionGroupEnd

;--------------------------------
; Icon Themes
Section "Icon Themes" SEC04

  SectionIn 1 2
  SetOutPath "$INSTDIR"
  File /r "smplayer-build\themes"

SectionEnd

;--------------------------------
; Translations
Section Translations SEC05

  SectionIn 1 2
  SetOutPath "$INSTDIR"
  File /r "smplayer-build\translations"

SectionEnd

;--------------------------------
; Section descriptions
!insertmacro MUI_FUNCTION_DESCRIPTION_BEGIN
  !insertmacro MUI_DESCRIPTION_TEXT ${SEC01} "SMPlayer, shared libraries, and documentation."
  !insertmacro MUI_DESCRIPTION_TEXT ${SEC02A} "Creates a shortcut on the desktop."
  !insertmacro MUI_DESCRIPTION_TEXT ${SEC02B} "Creates start menu shortcuts."
  !insertmacro MUI_DESCRIPTION_TEXT ${SEC03A} "Downloads/installs mplayer; requires an active internet connection. Required for playback."
  !insertmacro MUI_DESCRIPTION_TEXT ${SEC03B} "Downloads optional codecs that aren't yet implemented in mplayer; e.g. RealVideo and uncommon formats."
  !insertmacro MUI_DESCRIPTION_TEXT ${SEC04} "Stylish icon themes for SMPlayer."
  !insertmacro MUI_DESCRIPTION_TEXT ${SEC05} "Translations for SMPlayer."
!insertmacro MUI_FUNCTION_DESCRIPTION_END

Section -Post

  # Uninstall information
  WriteRegStr ${PRODUCT_UNINST_ROOT_KEY} "${PRODUCT_UNINST_KEY}" "DisplayName" "$(^Name)"
  WriteRegStr ${PRODUCT_UNINST_ROOT_KEY} "${PRODUCT_UNINST_KEY}" "UninstallString" "$INSTDIR\uninst.exe"
  WriteRegStr ${PRODUCT_UNINST_ROOT_KEY} "${PRODUCT_UNINST_KEY}" "DisplayIcon" "$INSTDIR\smplayer.exe"
  WriteRegStr ${PRODUCT_UNINST_ROOT_KEY} "${PRODUCT_UNINST_KEY}" "DisplayVersion" "${PRODUCT_VERSION}"
  WriteRegStr ${PRODUCT_UNINST_ROOT_KEY} "${PRODUCT_UNINST_KEY}" "HelpLink" "${PRODUCT_FORUM}"
  WriteRegStr ${PRODUCT_UNINST_ROOT_KEY} "${PRODUCT_UNINST_KEY}" "URLInfoAbout" "${PRODUCT_WEB_SITE}"
  WriteRegStr ${PRODUCT_UNINST_ROOT_KEY} "${PRODUCT_UNINST_KEY}" "URLUpdateInfo" "${PRODUCT_WEB_SITE}"
  WriteRegStr ${PRODUCT_UNINST_ROOT_KEY} "${PRODUCT_UNINST_KEY}" "Publisher" "${PRODUCT_PUBLISHER}"

SectionEnd

;--------------------------------
;Installer Functions

Function .onInit

  !insertmacro MUI_LANGDLL_DISPLAY

FunctionEnd

Function .onInstFailed

  # Delete desktop and start menu shortcuts
  SetShellVarContext all
  Delete "$DESKTOP\SMPlayer.lnk"
  RMDir /r "$SMPROGRAMS\${PRODUCT_STARTMENU_GROUP}"
	
  # Delete directories recursively except for main directory
  # Nullsoft says it is unsafe to recursively delete $INSTDIR 
  RMDir /r "$INSTDIR\docs"
  RMDir /r "$INSTDIR\imageformats"
  RMDir /r "$INSTDIR\mplayer"
  RMDir /r "$INSTDIR\shortcuts"
  RMDir /r "$INSTDIR\themes"
  RMDir /r "$INSTDIR\translations"
  Delete "$INSTDIR\*.txt"
  Delete "$INSTDIR\mingwm10.dll"
  Delete "$INSTDIR\Q*.dll"
  Delete "$INSTDIR\smplayer.exe"
  Delete "$INSTDIR\uninst.exe"
  Delete "$INSTDIR\dxlist.exe"
  RMDir "$INSTDIR"

  # Delete keys pertaining to SMPlayer
  DeleteRegKey ${PRODUCT_UNINST_ROOT_KEY} "${PRODUCT_UNINST_KEY}"
  DeleteRegKey HKCR "MPlayerFileVideo"
  DeleteRegKey HKLM "Software\SMPlayer"
  DeleteRegKey HKLM "Software\Clients\Media\SMPlayer"
  DeleteRegValue HKLM "Software\RegisteredApplications" "SMPlayer"

FunctionEnd

;End Installer Sections
;------------------------------------------------------------------------------------------------

;------------------------------------------------------------------------------------------------
;UnInstaller Sections

Section Uninstall

  # Restore all file associations...
  ExecWait '"$INSTDIR\smplayer.exe" -uninstall'

  # Delete desktop and start menu shortcuts
  SetShellVarContext all
  Delete "$DESKTOP\SMPlayer.lnk"
  RMDir /r "$SMPROGRAMS\${PRODUCT_STARTMENU_GROUP}"
	
  # Delete directories recursively except for main directory
  # Nullsoft says it is unsafe to recursively delete $INSTDIR 
  RMDir /r "$INSTDIR\docs"
  RMDir /r "$INSTDIR\imageformats"
  RMDir /r "$INSTDIR\mplayer"
  RMDir /r "$INSTDIR\shortcuts"
  RMDir /r "$INSTDIR\themes"
  RMDir /r "$INSTDIR\translations"
  Delete "$INSTDIR\*.txt"
  Delete "$INSTDIR\mingwm10.dll"
  Delete "$INSTDIR\Q*.dll"
  Delete "$INSTDIR\smplayer.exe"
  Delete "$INSTDIR\dxlist.exe"
  Delete "$INSTDIR\uninst.exe"
  RMDir "$INSTDIR"

  # Delete keys pertaining to SMPlayer
  DeleteRegKey ${PRODUCT_UNINST_ROOT_KEY} "${PRODUCT_UNINST_KEY}"
  DeleteRegKey HKCR "MPlayerFileVideo"
  DeleteRegKey HKLM "Software\SMPlayer"
  DeleteRegKey HKLM "Software\Clients\Media\SMPlayer"
  DeleteRegValue HKLM "Software\RegisteredApplications" "SMPlayer"
  SetAutoClose true

SectionEnd

;--------------------------------
;UnInstaller Functions
Function un.onInit

  # Get the stored language preference
  !insertmacro MUI_UNGETLANGUAGE

  MessageBox MB_ICONQUESTION|MB_YESNO|MB_DEFBUTTON2 "Are you sure you want to completely remove $(^Name) and all of its components?" IDYES +2
  Abort

FunctionEnd

Function un.onUninstSuccess

  HideWindow
  MessageBox MB_ICONINFORMATION|MB_OK "$(^Name) was successfully removed from your computer."

FunctionEnd