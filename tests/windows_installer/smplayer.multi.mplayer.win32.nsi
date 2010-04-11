; Installer script for win32 SMPlayer
; Written by redxii (redxii@users.sourceforge.net)
; Tested/Developed with Unicode NSIS 2.45.1

!ifndef VER_MAJOR | VER_MINOR | VER_BUILD
  !error "Version information not defined (or incomplete). You must define: VER_MAJOR, VER_MINOR, VER_BUILD."
!endif

;--------------------------------
;Compressor

  SetCompressor /SOLID lzma
  SetCompressorDictSize 32

;--------------------------------
;Additional plugin folders

  !addplugindir .

;--------------------------------
;Defines

!ifdef VER_REVISION
  !define SMPLAYER_VERSION "${VER_MAJOR}.${VER_MINOR}.${VER_BUILD}.${VER_REVISION}"
  !define SMPLAYER_PRODUCT_VERSION "${VER_MAJOR}.${VER_MINOR}.${VER_BUILD}.${VER_REVISION}"
!else ifndef VER_REVISION
  !define SMPLAYER_VERSION "${VER_MAJOR}.${VER_MINOR}.${VER_BUILD}"
  !define SMPLAYER_PRODUCT_VERSION "${VER_MAJOR}.${VER_MINOR}.${VER_BUILD}.0"
!endif

  !define SMPLAYER_APP_PATHS_KEY "Software\Microsoft\Windows\CurrentVersion\App Paths\smplayer.exe"
  !define SMPLAYER_DEFPROGRAMS_KEY "Software\Clients\Media\SMPlayer\Capabilities"
  !define SMPLAYER_REG_KEY "Software\SMPlayer"

  !define SMPLAYER_UNINST_EXE "uninst.exe"
  !define SMPLAYER_UNINST_KEY "Software\Microsoft\Windows\CurrentVersion\Uninstall\SMPlayer"

  ;Fallback versions
  ;These can be changed in the compiler, otherwise
  ;if not defined the values shown here will be used.
!ifndef DEFAULT_CODECS_VERSION
  !define DEFAULT_CODECS_VERSION "windows-essential-20071007"
!endif

!ifndef WITH_MPLAYER
  !ifndef DEFAULT_MPLAYER_GENERIC
    !define DEFAULT_MPLAYER_GENERIC "mplayer-svn-30945"
  !endif

  !ifndef DEFAULT_MPLAYER_AMDMT
    !define DEFAULT_MPLAYER_AMDMT "mplayer-amd-mt-30945"
  !endif

  !ifndef DEFAULT_MPLAYER_INTELMT
    !define DEFAULT_MPLAYER_INTELMT "mplayer-intel-mt-30945"
  !endif
!endif

  ;Version control
!ifndef VERSION_FILE_URL
  !define VERSION_FILE_URL "http://smplayer.sourceforge.net/mplayer-version-info"
!endif

;--------------------------------
;General

  ;Name and file
  Name "SMPlayer ${SMPLAYER_VERSION}"
  BrandingText "SMPlayer for Windows v${SMPLAYER_VERSION}"
!ifdef WITH_MPLAYER
  OutFile "smplayer-${SMPLAYER_VERSION}-win32.exe"
!else ifndef WITH_MPLAYER
  OutFile "smplayer-${SMPLAYER_VERSION}-win32-webdl.exe"
!endif

  ;Version tab properties
  VIProductVersion "${SMPLAYER_PRODUCT_VERSION}"
  VIAddVersionKey "ProductName" "SMPlayer"
  VIAddVersionKey "ProductVersion" "${SMPLAYER_VERSION}"
  VIAddVersionKey "FileVersion" "${SMPLAYER_VERSION}"
  VIAddVersionKey "LegalCopyright" ""
!ifdef WITH_MPLAYER
  VIAddVersionKey "FileDescription" "SMPlayer Installer (w/ MPlayer)"
!else ifndef WITH_MPLAYER
  VIAddVersionKey "FileDescription" "SMPlayer Installer (MPlayer Web Downloader)"
!endif

  ;Default installation folder
  InstallDir "$PROGRAMFILES\SMPlayer"

  ;Get installation folder from registry if available
  InstallDirRegKey HKLM "${SMPLAYER_REG_KEY}" "Path"

  ;Vista+ XML manifest, does not affect older OSes
  RequestExecutionLevel admin

  ShowInstDetails show
  ShowUnInstDetails show

;--------------------------------
;Variables

  Var BUTTON_MPLAYER_CHOICE1
  Var BUTTON_MPLAYER_CHOICE2
  Var BUTTON_MPLAYER_CHOICE3
  Var CODEC_VERSION
  Var IS_ADMIN
  Var MPLAYER_SELECTION_STATE
!ifndef WITH_MPLAYER
  Var MPLAYER_VERSION
!endif
  Var PREVIOUS_VERSION
  Var PREVIOUS_VERSION_STATE
  Var REINSTALL_UNINSTALL
  Var REINSTALL_UNINSTALLBUTTON
  Var USERNAME

;--------------------------------
;Interface Settings

  ; License page
  !define MUI_LICENSEPAGE_RADIOBUTTONS

  ; Components page
  !define MUI_COMPONENTSPAGE_SMALLDESC

  ; Finish page
  !define MUI_FINISHPAGE_NOREBOOTSUPPORT
  !define MUI_FINISHPAGE_RUN $INSTDIR\smplayer.exe
  !define MUI_FINISHPAGE_RUN_NOTCHECKED
  !define MUI_FINISHPAGE_SHOWREADME $INSTDIR\Release_notes.txt
  !define MUI_FINISHPAGE_SHOWREADME_NOTCHECKED
  !define MUI_FINISHPAGE_SHOWREADME_TEXT "View Release Notes"

  ; Misc
  !define MUI_WELCOMEFINISHPAGE_BITMAP "${NSISDIR}\Contrib\Graphics\Wizard\orange.bmp"
  !define MUI_UNWELCOMEFINISHPAGE_BITMAP "${NSISDIR}\Contrib\Graphics\Wizard\orange-uninstall.bmp"
  !define MUI_ABORTWARNING

  ;Installer/Uninstaller icons
  !define MUI_ICON "${NSISDIR}\Contrib\Graphics\Icons\orange-install.ico"
  !define MUI_UNICON "${NSISDIR}\Contrib\Graphics\Icons\orange-uninstall.ico"

  ;Language Selection Dialog Settings
  !define MUI_LANGDLL_REGISTRY_ROOT HKLM
  !define MUI_LANGDLL_REGISTRY_KEY "${SMPLAYER_UNINST_KEY}"
  !define MUI_LANGDLL_REGISTRY_VALUENAME "NSIS:Language"

  ;Memento Settings
  !define MEMENTO_REGISTRY_ROOT HKLM
  !define MEMENTO_REGISTRY_KEY "${SMPLAYER_REG_KEY}"

;--------------------------------
;Include Modern UI and functions

  !include MUI2.nsh
  !include FileFunc.nsh
  !include Memento.nsh
  !include nsDialogs.nsh
  !include Sections.nsh
  !include WinVer.nsh
  !include WordFunc.nsh

;--------------------------------
;Pages

  ;Install pages
  !insertmacro MUI_PAGE_WELCOME
  !insertmacro MUI_PAGE_LICENSE "smplayer-build\Copying.txt"
  Page custom PageReinstall PageLeaveReinstall
  !define MUI_PAGE_CUSTOMFUNCTION_PRE PageComponentsPre
  !insertmacro MUI_PAGE_COMPONENTS
  Page custom PageMPlayerBuild PageLeaveMPlayerBuild
  !define MUI_PAGE_CUSTOMFUNCTION_PRE PageDirectoryPre
  !insertmacro MUI_PAGE_DIRECTORY
  !define MUI_PAGE_CUSTOMFUNCTION_SHOW PageInstfilesShow
  !insertmacro MUI_PAGE_INSTFILES
  !insertmacro MUI_PAGE_FINISH

  ;Uninstall pages
  !define MUI_PAGE_CUSTOMFUNCTION_PRE un.ConfirmPagePre
  !insertmacro MUI_UNPAGE_CONFIRM
  !insertmacro MUI_UNPAGE_INSTFILES
  !define MUI_PAGE_CUSTOMFUNCTION_PRE un.FinishPagePre
  !insertmacro MUI_UNPAGE_FINISH

;--------------------------------
;Languages

  !insertmacro MUI_LANGUAGE "English"
  !insertmacro MUI_LANGUAGE "Basque"
  !insertmacro MUI_LANGUAGE "Catalan"
  !insertmacro MUI_LANGUAGE "Czech"
  !insertmacro MUI_LANGUAGE "Danish"
  !insertmacro MUI_LANGUAGE "Dutch"
  !insertmacro MUI_LANGUAGE "Finnish"
  !insertmacro MUI_LANGUAGE "French"
  !insertmacro MUI_LANGUAGE "German"
  !insertmacro MUI_LANGUAGE "Hebrew"
  !insertmacro MUI_LANGUAGE "Hungarian"
  !insertmacro MUI_LANGUAGE "Italian"
  !insertmacro MUI_LANGUAGE "Norwegian"
  !insertmacro MUI_LANGUAGE "Polish"
  !insertmacro MUI_LANGUAGE "Portuguese"
  !insertmacro MUI_LANGUAGE "Russian"
  !insertmacro MUI_LANGUAGE "Slovak"
  !insertmacro MUI_LANGUAGE "Slovenian"
  !insertmacro MUI_LANGUAGE "Spanish"

; Custom translations for setup

  !insertmacro LANGFILE_INCLUDE "translations\english.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\basque.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\catalan.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\czech.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\danish.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\dutch.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\finnish.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\french.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\german.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\hebrew.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\hungarian.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\italian.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\norwegian.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\polish.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\portuguese.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\russian.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\slovak.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\slovenian.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\spanish.nsh"

;--------------------------------
;Reserve Files

  ;These files should be inserted before other files in the data block
  ;Keep these lines before any File command
  ;Only for solid compression (by default, solid compression is enabled for BZIP2 and LZMA)

  !insertmacro MUI_RESERVEFILE_LANGDLL
  ReserveFile "${NSISDIR}\Plugins\UserInfo.dll"

;--------------------------------
;Installer Types

  InstType "Typical"
  InstType "Compact"
  InstType "Full"

;--------------------------------
;Installer Sections

;--------------------------------
;Main SMPlayer files
Section SMPlayer SMPlayer

  SectionIn 1 2 3 RO
  SetOutPath "$INSTDIR"
  File "smplayer-build\*"

  ;SMPlayer docs
  SetOutPath "$INSTDIR\docs"
  File /r "smplayer-build\docs\*.*"

  ;Qt imageformats
  SetOutPath "$INSTDIR\imageformats"
  File /r "smplayer-build\imageformats\*.*"

  ;SMPlayer key shortcuts
  SetOutPath "$INSTDIR\shortcuts"
  File /r "smplayer-build\shortcuts\*.*"

  SetOutPath "$PLUGINSDIR"
  File 7za.exe

  ;Initialize to 0 if don't exist (based on error flag)
  ClearErrors
  ReadRegDWORD $R0 HKLM "${SMPLAYER_REG_KEY}" Installed_MPlayer
  ${If} ${Errors}
    WriteRegDWORD HKLM "${SMPLAYER_REG_KEY}" Installed_MPlayer 0x0
  ${EndIf}
  ClearErrors
  ReadRegDWORD $R0 HKLM "${SMPLAYER_REG_KEY}" Installed_Codecs
  ${If} ${Errors}
    WriteRegDWORD HKLM "${SMPLAYER_REG_KEY}" Installed_Codecs 0x0
  ${EndIf}

SectionEnd

;--------------------------------
;Desktop shortcut
${MementoSection} "Desktop Shortcut" DesktopIcon
  SectionIn 1 3

  SetOutPath "$INSTDIR"
  SetShellVarContext all
  CreateShortCut "$DESKTOP\SMPlayer.lnk" "$INSTDIR\smplayer.exe"

${MementoSectionEnd}

;--------------------------------
;Start menu shortcuts
${MementoSection} "Start Menu Shortcut" StartMenuIcon
  SectionIn 1 3

  SetOutPath "$INSTDIR"
  SetShellVarContext all
  CreateDirectory "$SMPROGRAMS\SMPlayer"
  CreateShortCut "$SMPROGRAMS\SMPlayer\SMPlayer.lnk" "$INSTDIR\smplayer.exe"
  WriteINIStr    "$SMPROGRAMS\SMPlayer\SMPlayer on the Web.url" "InternetShortcut" "URL" "http://smplayer.sf.net"
  CreateShortCut "$SMPROGRAMS\SMPlayer\Uninstall SMPlayer.lnk" "$INSTDIR\${SMPLAYER_UNINST_EXE}"

${MementoSectionEnd}

;--------------------------------
;MPlayer & MPlayer Codecs
SectionGroup /e "MPlayer Components"

!ifdef WITH_MPLAYER
  Section MPlayer MPlayer
    SectionIn 1 2 3 RO

    /* All the other files for the FFmpeg-mt and CPU Detection builds
    should be the same so we'll share the folder contents; we have the mplayer
    executables named as so:
      mplayer.exe (Runtime CPU Detection)
      mplayer-amdmt.exe (AMD)
      mplayer-p4mt.exe (Intel)

    Exclude mplayer.exe from `smplayer-build\mplayer` with /x then
    include them individually depending on MPLAYER_SELECTION_STATE
    rename the Intel or AMD executable using `/oname=`. */
    SetOutPath "$INSTDIR\mplayer"
    File /r /x mplayer.exe "smplayer-build\mplayer\*.*"

    ${If} $MPLAYER_SELECTION_STATE == 1
      File "smplayer-build\mplayer\mplayer.exe"
    ${ElseIf} $MPLAYER_SELECTION_STATE == 2
      File /oname=mplayer.exe "mplayer-mt\mplayer-amdmt.exe"
    ${ElseIf} $MPLAYER_SELECTION_STATE == 3
      File /oname=mplayer.exe "mplayer-mt\mplayer-p4mt.exe"
    ${EndIf}

    WriteRegDWORD HKLM "${SMPLAYER_REG_KEY}" Installed_MPlayer 0x$MPLAYER_SELECTION_STATE

  SectionEnd
!else ifndef WITH_MPLAYER
  Section MPlayer MPlayer
    SectionIn 1 2 3 RO
    AddSize 16800

    Call GetVerInfo

    /* Read from version-info
    If it was unable to download, set version to that defined in the
    beginning of the script. */
    ${If} ${FileExists} "$PLUGINSDIR\version-info"

      ${If} $MPLAYER_SELECTION_STATE == 1
        ReadINIStr $MPLAYER_VERSION "$PLUGINSDIR\version-info" smplayer mplayer
      ${ElseIf} $MPLAYER_SELECTION_STATE == 2
        ReadINIStr $MPLAYER_VERSION "$PLUGINSDIR\version-info" smplayer mplayer-ffmpegmt-amd
      ${ElseIf} $MPLAYER_SELECTION_STATE == 3
        ReadINIStr $MPLAYER_VERSION "$PLUGINSDIR\version-info" smplayer mplayer-ffmpegmt-intel
      ${EndIf}

    ${Else}

      ${If} $MPLAYER_SELECTION_STATE == 1
        StrCpy $MPLAYER_VERSION ${DEFAULT_MPLAYER_GENERIC}
      ${ElseIf} $MPLAYER_SELECTION_STATE == 2
        StrCpy $MPLAYER_VERSION ${DEFAULT_MPLAYER_AMDMT}
      ${ElseIf} $MPLAYER_SELECTION_STATE == 3
        StrCpy $MPLAYER_VERSION ${DEFAULT_MPLAYER_INTELMT}
      ${EndIf}

    ${EndIf}

    retry_mplayer:

    DetailPrint $(MPLAYER_IS_DOWNLOADING)
    inetc::get /timeout 30000 /resume "" /caption $(MPLAYER_IS_DOWNLOADING) /banner "Downloading $MPLAYER_VERSION.7z" \
    "http://downloads.sourceforge.net/smplayer/$MPLAYER_VERSION.7z?big_mirror=0" \
    "$PLUGINSDIR\$MPLAYER_VERSION.7z" /end
    Pop $R0
    StrCmp $R0 OK 0 check_mplayer

    ;Extract
    nsExec::Exec '"$PLUGINSDIR\7za.exe" x "$PLUGINSDIR\$MPLAYER_VERSION.7z" -y -o"$PLUGINSDIR"'

    ;Copy
    CreateDirectory "$INSTDIR\mplayer"
    CopyFiles /SILENT "$PLUGINSDIR\$MPLAYER_VERSION\*" "$INSTDIR\mplayer"

    check_mplayer:
    ;This label does not necessarily mean there was a download error, so check first
    ${If} $R0 != "OK"
      DetailPrint $(MPLAYER_DL_FAILED)
    ${EndIf}

    IfFileExists "$INSTDIR\mplayer\mplayer.exe" mplayerInstSuccess mplayerInstFailed
      mplayerInstSuccess:
        WriteRegDWORD HKLM "${SMPLAYER_REG_KEY}" Installed_MPlayer 0x$MPLAYER_SELECTION_STATE
        Goto done
      mplayerInstFailed:
        MessageBox MB_RETRYCANCEL|MB_ICONEXCLAMATION $(MPLAYER_DL_RETRY) /SD IDCANCEL IDRETRY retry_mplayer
        Abort $(MPLAYER_INST_FAILED)

    done:

  SectionEnd
!endif

;--------------------------------
;MPlayer codecs
  Section /o "Binary Codecs" Codecs
    SectionIn 3
    AddSize 22300

    Call GetVerInfo

    /* Read from version-info
    If it was unable to download, set version to that defined in the
    beginning of the script. */
    ${If} ${FileExists} "$PLUGINSDIR\version-info"
      ReadINIStr $CODEC_VERSION "$PLUGINSDIR\version-info" smplayer mplayercodecs
    ${Else}
      StrCpy $CODEC_VERSION ${DEFAULT_CODECS_VERSION}
    ${EndIf}

    retry_codecs:

    DetailPrint $(CODECS_IS_DOWNLOADING)
    inetc::get /timeout 30000 /resume "" /caption $(CODECS_IS_DOWNLOADING) /banner "Downloading $CODEC_VERSION.zip" \
    "http://www.mplayerhq.hu/MPlayer/releases/codecs/$CODEC_VERSION.zip" \
    "$PLUGINSDIR\$CODEC_VERSION.zip" /end
    Pop $R0
    StrCmp $R0 OK 0 check_codecs

    ;Extract
    nsExec::Exec '"$PLUGINSDIR\7za.exe" x "$PLUGINSDIR\$CODEC_VERSION.zip" -y -o"$PLUGINSDIR"'

    ;Copy
    CreateDirectory "$INSTDIR\mplayer\codecs"
    CopyFiles /SILENT "$PLUGINSDIR\$CODEC_VERSION\*" "$INSTDIR\mplayer\codecs"

    check_codecs:
    ;This label does not necessarily mean there was a download error, so check first
    ${If} $R0 != "OK"
      DetailPrint $(CODECS_DL_FAILED)
    ${EndIf}

    IfFileExists "$INSTDIR\mplayer\codecs\*.dll" codecsInstSuccess codecsInstFailed
      codecsInstSuccess:
        WriteRegDWORD HKLM "${SMPLAYER_REG_KEY}" Installed_Codecs 0x1
        Goto done
      codecsInstFailed:
        MessageBox MB_RETRYCANCEL|MB_ICONEXCLAMATION $(CODECS_DL_RETRY) /SD IDCANCEL IDRETRY retry_codecs
        DetailPrint $(CODECS_INST_FAILED)
        WriteRegDWORD HKLM "${SMPLAYER_REG_KEY}" Installed_Codecs 0x0
        Sleep 5000

    done:

	SectionEnd

SectionGroupEnd

;--------------------------------
;Icon themes
${MementoSection} "Icon Themes" Themes

  SectionIn 1 3
  SetOutPath "$INSTDIR\themes"
  File /r "smplayer-build\themes\*.*"

${MementoSectionEnd}

;--------------------------------
;Translations
${MementoSection} Translations Translations

  SectionIn 1 3
  SetOutPath "$INSTDIR\translations"
  File /r "smplayer-build\translations\*.*"

${MementoSectionEnd}

;--------------------------------
;Install/Uninstall information
Section -Post

  ;Uninstall file
  WriteUninstaller "$INSTDIR\${SMPLAYER_UNINST_EXE}"

  ;Store installed path & version
  WriteRegStr HKLM "${SMPLAYER_REG_KEY}" "Path" "$INSTDIR"
  WriteRegStr HKLM "${SMPLAYER_REG_KEY}" "Version" "${SMPLAYER_VERSION}"

  ;Allows user to use 'start smplayer.exe'
  WriteRegStr HKLM "${SMPLAYER_APP_PATHS_KEY}" "" "$INSTDIR\smplayer.exe"

  ;Registry entries needed for Default Programs in Vista & later
  ${If} ${AtLeastWinVista}
    Call DefaultProgramsReg
  ${EndIf}

  ;Registry Uninstall information
  WriteRegStr HKLM "${SMPLAYER_UNINST_KEY}" "DisplayName" "$(^Name)"
  WriteRegStr HKLM "${SMPLAYER_UNINST_KEY}" "DisplayIcon" "$INSTDIR\smplayer.exe"
  WriteRegStr HKLM "${SMPLAYER_UNINST_KEY}" "DisplayVersion" "${SMPLAYER_VERSION}"
  WriteRegStr HKLM "${SMPLAYER_UNINST_KEY}" "HelpLink" "http://smplayer.berlios.de/forum"
  WriteRegStr HKLM "${SMPLAYER_UNINST_KEY}" "Publisher" "Ricardo Villalba"
  WriteRegStr HKLM "${SMPLAYER_UNINST_KEY}" "UninstallString" "$INSTDIR\${SMPLAYER_UNINST_EXE}"
  WriteRegStr HKLM "${SMPLAYER_UNINST_KEY}" "URLInfoAbout" "http://smplayer.sf.net"
  WriteRegStr HKLM "${SMPLAYER_UNINST_KEY}" "URLUpdateInfo" "http://smplayer.sf.net"
  WriteRegDWORD HKLM "${SMPLAYER_UNINST_KEY}" "NoModify" "1"
  WriteRegDWORD HKLM "${SMPLAYER_UNINST_KEY}" "NoRepair" "1"

SectionEnd

${MementoSectionDone}

;--------------------------------
;Section descriptions
!insertmacro MUI_FUNCTION_DESCRIPTION_BEGIN
  !insertmacro MUI_DESCRIPTION_TEXT ${SMPlayer} "SMPlayer, shared libraries, and documentation."
  !insertmacro MUI_DESCRIPTION_TEXT ${DesktopIcon} "Creates a shortcut on the desktop."
  !insertmacro MUI_DESCRIPTION_TEXT ${StartMenuIcon} "Creates start menu shortcuts."
!ifdef WITH_MPLAYER
  !insertmacro MUI_DESCRIPTION_TEXT ${MPlayer} "The engine behind SMPlayer, required for playback."
!else ifndef WITH_MPLAYER
  !insertmacro MUI_DESCRIPTION_TEXT ${MPlayer} "Downloads/installs MPlayer; requires an active internet connection. Required for playback."
!endif
  !insertmacro MUI_DESCRIPTION_TEXT ${Codecs} "Downloads/installs optional binary codecs for MPlayer; requires an active internet connection."
  !insertmacro MUI_DESCRIPTION_TEXT ${Themes} "Additional icon themes for SMPlayer."
  !insertmacro MUI_DESCRIPTION_TEXT ${Translations} "Translations for the SMPlayer interface && help into 30+ additional languages."
!insertmacro MUI_FUNCTION_DESCRIPTION_END

;--------------------------------
;Installer functions

Function .onInit

  /* Check if setup is already running */
  System::Call 'kernel32::CreateMutexW(i 0, i 0, t "MPlayerSMPlayer") i .r1 ?e'
  Pop $R0

  StrCmp $R0 0 +3
    MessageBox MB_OK|MB_ICONEXCLAMATION $(SMPLAYER_INSTALLER_IS_RUNNING)
    Abort

  /* Privileges Check */
  Call CheckUserRights

  ;Check for admin (mimic old Inno Setup behavior)
  ${If} $IS_ADMIN == 0
    MessageBox MB_OK|MB_ICONSTOP $(SMPLAYER_INSTALLER_NO_ADMIN)
    Abort
  ${EndIf}

  /* Ask for setup language */
  !insertmacro MUI_LANGDLL_DISPLAY

  Call CheckPreviousVersion

  Call LoadPreviousSettings

FunctionEnd

Function .onInstSuccess

  ${MementoSectionSave}

FunctionEnd

Function .onInstFailed

  Call UninstallSMPlayer

  Delete "$INSTDIR\${SMPLAYER_UNINST_EXE}"
  RMDir "$INSTDIR"

FunctionEnd

Function .onSelChange

  SectionGetFlags ${Codecs} $R0
  ${If} $R0 != $R1
    StrCpy $R1 $R0
    IntOp $R0 $R0 & ${SF_SELECTED}
  ${If} $R0 == ${SF_SELECTED}
    MessageBox MB_OK|MB_ICONINFORMATION $(MPLAYER_CODEC_INFORMATION)
  ${EndIf}
  ${EndIf}

FunctionEnd

Function CheckPreviousVersion

  ReadRegStr $PREVIOUS_VERSION HKLM "${SMPLAYER_REG_KEY}" "Version"

  /* $PREVIOUS_VERSION_STATE Assignments:
  $PREVIOUS_VERSION_STATE=0  This installer is the same version as the installed copy
  $PREVIOUS_VERSION_STATE=1  A newer version than this installer is already installed
  $PREVIOUS_VERSION_STATE=2  An older version than this installer is already installed */
  ${VersionCompare} $PREVIOUS_VERSION ${SMPLAYER_VERSION} $PREVIOUS_VERSION_STATE

FunctionEnd

Function CheckUserRights

  ClearErrors
  UserInfo::GetName
  ${If} ${Errors}
    StrCpy $IS_ADMIN 1
    Return
  ${EndIf}

  Pop $USERNAME
  UserInfo::GetAccountType
  Pop $R0
  ${Switch} $R0
    ${Case} "Admin"
    ${Case} "Power"
      StrCpy $IS_ADMIN 1
      ${Break}
    ${Default}
      StrCpy $IS_ADMIN 0
      ${Break}
  ${EndSwitch}

FunctionEnd

Function DefaultProgramsReg

  ;HKEY_CLASSES_ROOT ProgId registration
  WriteRegStr HKCR "MPlayerFileVideo\DefaultIcon" "" '"$INSTDIR\smplayer.exe",1'
  WriteRegStr HKCR "MPlayerFileVideo\shell\enqueue" "" "Enqueue in SMPlayer"
  WriteRegStr HKCR "MPlayerFileVideo\shell\enqueue\command" "" '"$INSTDIR\smplayer.exe" -add-to-playlist "%1"'
  WriteRegStr HKCR "MPlayerFileVideo\shell\open" "FriendlyAppName" "SMPlayer Media Player"
  WriteRegStr HKCR "MPlayerFileVideo\shell\open\command" "" '"$INSTDIR\smplayer.exe" "%1"'

  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}" "ApplicationDescription" $(APPLICATION_DESCRIPTION)
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}" "ApplicationName" "SMPlayer"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".3gp" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".ac3" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".ape" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".asf" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".avi" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".bin" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".dat" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".divx" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".dv" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".dvr-ms" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".flac" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".flv" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".iso" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".m1v" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".m2t" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".m2ts" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".m2v" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".m3u" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".m3u8" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".m4v" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".mkv" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".mov" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".mp3" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".mp4" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".mpeg" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".mpg" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".mpv" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".mqv" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".nsv" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".ogg" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".ogm" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".ogv" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".pls" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".ra" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".ram" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".rec" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".rm" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".rmvb" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".swf" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".ts" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".vcd" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".vfw" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".vob" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".wav" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".wma" "MPlayerFileVideo"
  WriteRegStr HKLM "${SMPLAYER_DEFPROGRAMS_KEY}\FileAssociations" ".wmv" "MPlayerFileVideo"
  WriteRegStr HKLM "Software\RegisteredApplications" "SMPlayer" "${SMPLAYER_DEFPROGRAMS_KEY}"

FunctionEnd

Function GetVerInfo

  IfFileExists "$PLUGINSDIR\version-info" end_dl_ver_info 0
    DetailPrint $(VERINFO_IS_DOWNLOADING)
    inetc::get /timeout 30000 /resume "" /silent ${VERSION_FILE_URL} "$PLUGINSDIR\version-info" /end
    Pop $R0
    StrCmp $R0 OK +2
      DetailPrint $(VERINFO_DL_FAILED)

  end_dl_ver_info:

FunctionEnd

Function LoadPreviousSettings

  ;Retrieves MPlayer build
  ReadRegDWORD $MPLAYER_SELECTION_STATE HKLM "${SMPLAYER_REG_KEY}" "Installed_MPlayer"

  ;MPlayer codecs section doesn't use Memento so we need to restore it manually
  ReadRegDWORD $R0 HKLM "${SMPLAYER_REG_KEY}" "Installed_Codecs"
  ${If} $R0 == 1
    !insertmacro SelectSection ${Codecs}
  ${EndIf}

  ${MementoSectionRestore}

FunctionEnd

Function PageMPlayerBuild

  ;Skip if doing reinstall
  ${If} $REINSTALL_UNINSTALL == 1
    Abort
  ${EndIf}

  nsDialogs::Create /NOUNLOAD 1018
  Pop $0

  !insertmacro MUI_HEADER_TEXT "Choose MPlayer Build" "Choose which MPlayer build you would like to install."
  ${NSD_CreateLabel} 0 0 90% 10u "Select an MPlayer build you would like to install and click Next to continue."

  ${NSD_CreateRadioButton} 10 35 100% 10u "Runtime CPU Detection (Generic)"
  Pop $BUTTON_MPLAYER_CHOICE1
  ${NSD_AddStyle} $BUTTON_MPLAYER_CHOICE1 ${WS_GROUP}
  ${NSD_CreateLabel} 26 50 90% 20u "Generic build for all x86/x86-64 CPUs using runtime cpudetection; performance is limited with multi-core processors. If you are unsure, select this build."

  ${NSD_CreateRadioButton} 10 85 100% 10u "AMD Multi-Core Processors (X2/X3/X4/Phenom/etc)"
  Pop $BUTTON_MPLAYER_CHOICE2
  ${NSD_CreateLabel} 26 100 90% 20u "FFmpeg-mt build optimized to take advantage of multi-core AMD processors for optimal high definition video playback."

  ${NSD_CreateRadioButton} 10 135 100% 10u "Intel Multi-Core Processors (P4EE/P4D/Xeon/Core2/i7/etc)"
  Pop $BUTTON_MPLAYER_CHOICE3
  ${NSD_CreateLabel} 26 150 90% 20u "FFmpeg-mt build optimized to take advantage of multi-core Intel processors for optimal high definition video playback."

  /* Restores selection when the user leaves the page and comes back
  or sets the default choice (last Else statement) if they are viewing
  the page for the first time. */
  ${If} $MPLAYER_SELECTION_STATE == 1
    SendMessage $BUTTON_MPLAYER_CHOICE1 ${BM_SETCHECK} 1 0
  ${ElseIf} $MPLAYER_SELECTION_STATE == 2
    SendMessage $BUTTON_MPLAYER_CHOICE2 ${BM_SETCHECK} 1 0
  ${ElseIf} $MPLAYER_SELECTION_STATE == 3
    SendMessage $BUTTON_MPLAYER_CHOICE3 ${BM_SETCHECK} 1 0
  ${Else}
    SendMessage $BUTTON_MPLAYER_CHOICE1 ${BM_SETCHECK} 1 0
  ${EndIf}

  nsDialogs::Show

FunctionEnd

Function PageReinstall

  ${If} $PREVIOUS_VERSION == ""
    Abort
  ${EndIf}

  nsDialogs::Create /NOUNLOAD 1018
  Pop $0

  ${If} $PREVIOUS_VERSION_STATE == 2

    !insertmacro MUI_HEADER_TEXT $(REINSTALL_HEADER_TEXT) $(REINSTALL_HEADER_SUBTEXT)
    nsDialogs::CreateItem /NOUNLOAD STATIC ${WS_VISIBLE}|${WS_CHILD}|${WS_CLIPSIBLINGS} 0 0 0 100% 40 $(REINSTALL_OLDVER_DESCRIPTION)
    Pop $R0
    nsDialogs::CreateItem /NOUNLOAD BUTTON ${BS_AUTORADIOBUTTON}|${BS_VCENTER}|${BS_MULTILINE}|${WS_VISIBLE}|${WS_CHILD}|${WS_CLIPSIBLINGS}|${WS_GROUP}|${WS_TABSTOP} 0 10 55 100% 30 $(REINSTALL_OLDVER_UPGRADE)
    Pop $REINSTALL_UNINSTALLBUTTON
    nsDialogs::CreateItem /NOUNLOAD BUTTON ${BS_AUTORADIOBUTTON}|${BS_TOP}|${BS_MULTILINE}|${WS_VISIBLE}|${WS_CHILD}|${WS_CLIPSIBLINGS} 0 10 85 100% 50 $(REINSTALL_CHGSETTINGS)
    Pop $R0

    ${If} $REINSTALL_UNINSTALL == ""
      StrCpy $REINSTALL_UNINSTALL 1
    ${EndIf}

  ${ElseIf} $PREVIOUS_VERSION_STATE == 1

    !insertmacro MUI_HEADER_TEXT $(REINSTALL_HEADER_TEXT) $(REINSTALL_HEADER_SUBTEXT)
    nsDialogs::CreateItem /NOUNLOAD STATIC ${WS_VISIBLE}|${WS_CHILD}|${WS_CLIPSIBLINGS} 0 0 0 100% 40 $(REINSTALL_NEWVER_DESCRIPTION)
    Pop $R0
    nsDialogs::CreateItem /NOUNLOAD BUTTON ${BS_AUTORADIOBUTTON}|${BS_VCENTER}|${BS_MULTILINE}|${WS_VISIBLE}|${WS_CHILD}|${WS_CLIPSIBLINGS}|${WS_GROUP}|${WS_TABSTOP} 0 10 55 100% 30 $(REINSTALL_NEWVER_DOWNGRADE)
    Pop $REINSTALL_UNINSTALLBUTTON
    nsDialogs::CreateItem /NOUNLOAD BUTTON ${BS_AUTORADIOBUTTON}|${BS_TOP}|${BS_MULTILINE}|${WS_VISIBLE}|${WS_CHILD}|${WS_CLIPSIBLINGS} 0 10 85 100% 50 $(REINSTALL_CHGSETTINGS)
    Pop $R0

    ${If} $REINSTALL_UNINSTALL == ""
      StrCpy $REINSTALL_UNINSTALL 1
    ${EndIf}

  ${ElseIf} $PREVIOUS_VERSION_STATE == 0

    !insertmacro MUI_HEADER_TEXT $(REINSTALL_HEADER_TEXT) $(REINSTALL_HEADER_SUBTEXT_MAINT)
    nsDialogs::CreateItem /NOUNLOAD STATIC ${WS_VISIBLE}|${WS_CHILD}|${WS_CLIPSIBLINGS} 0 0 0 100% 40 $(REINSTALL_SAMEVER_DESCRIPTION)
    Pop $R0
    nsDialogs::CreateItem /NOUNLOAD BUTTON ${BS_AUTORADIOBUTTON}|${BS_VCENTER}|${BS_MULTILINE}|${WS_VISIBLE}|${WS_CHILD}|${WS_CLIPSIBLINGS}|${WS_GROUP}|${WS_TABSTOP} 0 10 55 100% 30 $(REINSTALL_SAMEVER_ADDREMREINST)
    Pop $R0
    nsDialogs::CreateItem /NOUNLOAD BUTTON ${BS_AUTORADIOBUTTON}|${BS_TOP}|${BS_MULTILINE}|${WS_VISIBLE}|${WS_CHILD}|${WS_CLIPSIBLINGS} 0 10 85 100% 50 $(REINSTALL_SAMEVER_UNINSTSMP)
    Pop $REINSTALL_UNINSTALLBUTTON

    ${If} $REINSTALL_UNINSTALL == ""
      StrCpy $REINSTALL_UNINSTALL 2
    ${EndIf}

  ${Else}

    MessageBox MB_ICONSTOP $(REINSTALL_UNKNOWN_VALUE) /SD IDOK
    Abort

  ${EndIf}

  ${If} $REINSTALL_UNINSTALL == 1
    SendMessage $REINSTALL_UNINSTALLBUTTON ${BM_SETCHECK} 1 0
  ${Else}
    SendMessage $R0 ${BM_SETCHECK} 1 0
  ${EndIf}

  nsDialogs::Show

FunctionEnd

Function PageComponentsPre

  ${If} $REINSTALL_UNINSTALL == 1
    Abort
  ${EndIf}

FunctionEnd

Function PageDirectoryPre

  ${If} $REINSTALL_UNINSTALL == 1
    Abort
  ${EndIf}

FunctionEnd

Function PageInstfilesShow

  ${If} $REINSTALL_UNINSTALL != ""
    Call RunUninstaller
    BringToFront
  ${EndIf}

FunctionEnd

Function PageLeaveMPlayerBuild

  /* Gets the state of each of the choices.
  The radio button selected is assigned '1',
  the rest should be '0'.*/
  ${NSD_GetState} $BUTTON_MPLAYER_CHOICE1 $R0
  ${NSD_GetState} $BUTTON_MPLAYER_CHOICE2 $R1
  ${NSD_GetState} $BUTTON_MPLAYER_CHOICE3 $R2

  /* $MPLAYER_SELECTION_STATE Assignments:
  1 = Generic RTM Build
  2 = FFmpeg-mt AMD Build
  3 = FFmepg-mt Intel Build */
  ${If} $R0 == 1
    StrCpy $MPLAYER_SELECTION_STATE 1
  ${ElseIf} $R1 == 1
    StrCpy $MPLAYER_SELECTION_STATE 2
  ${ElseIf} $R2 == 1
    StrCpy $MPLAYER_SELECTION_STATE 3
  ${EndIf}

FunctionEnd

Function PageLeaveReinstall

  SendMessage $REINSTALL_UNINSTALLBUTTON ${BM_GETCHECK} 0 0 $R0
  ${If} $R0 == 1
    ; Option to uninstall old version selected
    StrCpy $REINSTALL_UNINSTALL 1
  ${Else}
    ; Custom up/downgrade or add/remove/reinstall
    StrCpy $REINSTALL_UNINSTALL 2
  ${EndIf}

  ${If} $REINSTALL_UNINSTALL == 1
    ${If} $PREVIOUS_VERSION_STATE == 0
      Call RunUninstaller
      Quit
    ${Else}
  ${EndIf}

  ${EndIf}

FunctionEnd

Function RunUninstaller

  ReadRegStr $R1 HKLM "${SMPLAYER_UNINST_KEY}" "UninstallString"

  ${If} $R1 == ""
    Return
  ${EndIf}

  ;Run uninstaller
  HideWindow

  ClearErrors

  ${If} $PREVIOUS_VERSION_STATE == 0
  ${AndIf} $REINSTALL_UNINSTALL == 1
    ExecWait '$R1 _?=$INSTDIR'
  ${Else}
    ExecWait '$R1 /frominstall _?=$INSTDIR'
  ${EndIf}

  IfErrors no_remove_uninstaller

  IfFileExists "$INSTDIR\${SMPLAYER_UNINST_EXE}" 0 no_remove_uninstaller

    Delete "$R1"
    RMDir $INSTDIR

 no_remove_uninstaller:

FunctionEnd

;--------------------------------
;Shared functions

!macro UninstallSMPlayerMacro un
Function ${un}UninstallSMPlayer

  ;Delete desktop and start menu shortcuts
  SetDetailsPrint textonly
  DetailPrint "Deleting Shortcuts..."
  SetDetailsPrint listonly

  SetShellVarContext all
  Delete "$DESKTOP\SMPlayer.lnk"
  Delete "$SMPROGRAMS\SMPlayer\SMPlayer.lnk" 
  Delete "$SMPROGRAMS\SMPlayer\SMPlayer on the Web.url"
  Delete "$SMPROGRAMS\SMPlayer\Uninstall SMPlayer.lnk"
  RMDir "$SMPROGRAMS\SMPlayer"

  ;Delete directories recursively except for main directory
  ;Do not recursively delete $INSTDIR
  SetDetailsPrint textonly
  DetailPrint "Deleting Files..."
  SetDetailsPrint listonly

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

  ;Delete registry keys
  SetDetailsPrint textonly
  DetailPrint "Deleting Registry Keys..."
  SetDetailsPrint listonly

  DeleteRegKey HKLM "${SMPLAYER_REG_KEY}"
  DeleteRegKey HKLM "${SMPLAYER_APP_PATHS_KEY}"
  DeleteRegKey HKLM "${SMPLAYER_UNINST_KEY}"
  DeleteRegKey HKCR "MPlayerFileVideo"
  DeleteRegKey HKLM "Software\Clients\Media\SMPlayer"
  DeleteRegValue HKLM "Software\RegisteredApplications" "SMPlayer"

  SetDetailsPrint both

FunctionEnd
!macroend
!insertmacro UninstallSMPlayerMacro ""
!insertmacro UninstallSMPlayerMacro "un."

/*************************************** Uninstaller *******************************************/

Section Uninstall

  ;Make sure SMPlayer is installed from where the uninstaller is being executed.
  IfFileExists $INSTDIR\smplayer.exe smplayer_installed
    MessageBox MB_YESNO $(SMPLAYER_NOT_INSTALLED) /SD IDNO IDYES smplayer_installed
    Abort $(UNINSTALL_ABORTED)

  smplayer_installed:

  SetDetailsPrint textonly
  DetailPrint "Restoring file associations..."
  SetDetailsPrint listonly

  ;Don't restore file associations if reinstalling
  ${un.GetParameters} $R0
  ${un.GetOptions} $R0 "/frominstall" $R1

  IfErrors 0 +2
  ExecWait '"$INSTDIR\smplayer.exe" -uninstall'

  Call un.UninstallSMPlayer

  Delete "$INSTDIR\${SMPLAYER_UNINST_EXE}"
  RMDir "$INSTDIR"

SectionEnd

;--------------------------------
;Required functions

!insertmacro un.GetParameters
!insertmacro un.GetOptions

;--------------------------------
;Uninstaller functions

Function un.onInit

  Call un.CheckUserRights

  ;Check for admin (mimic old Inno Setup behavior)
  ${If} $IS_ADMIN == 0
    MessageBox MB_OK|MB_ICONSTOP $(UNINSTALL_NO_ADMIN)
    Abort
  ${EndIf}

  ;Get the stored language preference
  !insertmacro MUI_UNGETLANGUAGE

FunctionEnd

Function un.CheckUserRights

  ClearErrors
  UserInfo::GetName
  ${If} ${Errors}
    StrCpy $IS_ADMIN 1
    Return
  ${EndIf}

  Pop $USERNAME
  UserInfo::GetAccountType
  Pop $R0
  ${Switch} $R0
    ${Case} "Admin"
    ${Case} "Power"
      StrCpy $IS_ADMIN 1
      ${Break}
    ${Default}
      StrCpy $IS_ADMIN 0
      ${Break}
  ${EndSwitch}

FunctionEnd

Function un.ConfirmPagePre

  ${un.GetParameters} $R0

  ${un.GetOptions} $R0 "/frominstall" $R1
  ${Unless} ${Errors}
    Abort
  ${EndUnless}

FunctionEnd

Function un.FinishPagePre

  ${un.GetParameters} $R0

  ${un.GetOptions} $R0 "/frominstall" $R1
  ${Unless} ${Errors}
    Abort
  ${EndUnless}

FunctionEnd