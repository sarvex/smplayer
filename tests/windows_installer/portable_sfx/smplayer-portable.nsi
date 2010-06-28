; Installer script for win32 SMPlayer Portable Edition
; Written by redxii (redxii@users.sourceforge.net)
; Tested/Developed with Unicode NSIS 2.45.1/2.46

!ifndef VER_MAJOR | VER_MINOR | VER_BUILD
  !error "Version information not defined (or incomplete). You must define: VER_MAJOR, VER_MINOR, VER_BUILD."
!endif

;--------------------------------
;Compressor

  SetCompressor /SOLID lzma
  SetCompressorDictSize 32

;--------------------------------
;Additional plugin folders

;--------------------------------
;Defines

!ifdef VER_REVISION
  !define SMPLAYER_VERSION "${VER_MAJOR}.${VER_MINOR}.${VER_BUILD}.${VER_REVISION}"
  !define SMPLAYER_PRODUCT_VERSION "${VER_MAJOR}.${VER_MINOR}.${VER_BUILD}.${VER_REVISION}"
!else ifndef VER_REVISION
  !define SMPLAYER_VERSION "${VER_MAJOR}.${VER_MINOR}.${VER_BUILD}"
  !define SMPLAYER_PRODUCT_VERSION "${VER_MAJOR}.${VER_MINOR}.${VER_BUILD}.0"
!endif

;--------------------------------
;General

  ;Name and file
  Name "SMPlayer"
  BrandingText "SMPlayer v${SMPLAYER_VERSION} Portable Edition"
!ifdef WITH_MULTIMP
  OutFile "smplayer-${SMPLAYER_VERSION}-multimp-portable.exe"
!else ifndef WITH_MULTIMP
  OutFile "smplayer-${SMPLAYER_VERSION}-portable.exe"
!endif

  ;Installer/Uninstaller icons
  !define MUI_ICON "7z.ico"

  ;Version tab properties
  VIProductVersion "${SMPLAYER_PRODUCT_VERSION}"
  VIAddVersionKey "ProductName" "SMPlayer Portable Edition"
  VIAddVersionKey "ProductVersion" "${SMPLAYER_VERSION}"
  VIAddVersionKey "FileVersion" "${SMPLAYER_VERSION}"
  VIAddVersionKey "LegalCopyright" ""
  VIAddVersionKey "FileDescription" "SMPlayer Portable Extractor"

  ;Default extraction folder
  InstallDir ".\SMPlayer-Portable-${SMPLAYER_VERSION}"

  ;Request application privileges for Windows Vista/7
  RequestExecutionLevel user

  ShowInstDetails nevershow

  !include MUI2.nsh
!ifdef WITH_MULTIMP
  !include nsDialogs.nsh

  Var 7zIcon
  Var 7zIcon_Handle
  Var MPlayer_Choice1
  Var MPlayer_Choice1_State
  Var MPlayer_Choice2
  Var MPlayer_Choice2_State
  Var MPlayer_Choice3
  Var MPlayer_Choice3_State
  Var MPlayer_Selection_State
!endif

;--------------------------------
;Interface Settings

  Caption "SMPlayer Portable Edition ${SMPLAYER_VERSION}"
!ifdef WITH_MULTIMP
  DirText "Select a folder to extract SMPlayer Portable Edition to. $_CLICK" "" "" "Select the folder to extract SMPlayer to:"
!else ifndef WITH_MULTIMP
  DirText "Select a folder to extract SMPlayer Portable Edition to. Click Extract to continue." "" "" "Select the folder to extract SMPlayer to:"
!endif
  InstallButtonText "Extract"

  !define MUI_UI "${NSISDIR}\Contrib\UIs\sdbarker_tiny.exe" 

;--------------------------------
;Pages

  ;Install pages
  !insertmacro MUI_PAGE_DIRECTORY
!ifdef WITH_MULTIMP
  Page custom PageMPlayerBuild PageLeaveMPlayerBuild
!endif
  !insertmacro MUI_PAGE_INSTFILES

;--------------------------------
;Languages

  !insertmacro MUI_LANGUAGE "English"

;--------------------------------
;Installer Functions

!ifdef WITH_MULTIMP
Function PageMPlayerBuild

  nsDialogs::Create /NOUNLOAD 1018
  Pop $1

  ${NSD_CreateIcon} 0 0 32 32 icon
  Pop $7zIcon
  ${NSD_SetIconFromInstaller} $7zIcon $7zIcon_Handle
  
  ${NSD_CreateLabel} 25u 0 241u 18u "Select an MPlayer build optimized for your CPU. If you are unsure, select 'Runtime CPU Detection'. Click Extract to continue."

  ${NSD_CreateRadioButton} 10u 25u 100% 10u "Runtime CPU Detection (x86/x86-64 Generic)"
  Pop $MPlayer_Choice1

  ${NSD_CreateRadioButton} 10u 38u 100% 10u "AMD Multi-Core Processors (X2/X3/X4/Phenom/etc)"
  Pop $MPlayer_Choice2

  ${NSD_CreateRadioButton} 10u 51u 100% 10u "Intel Multi-Core Processors (P4EE/P4D/Xeon/Core2/i7/etc)"
  Pop $MPlayer_Choice3

  SendMessage $MPlayer_Choice1 ${BM_SETCHECK} 1 0

  nsDialogs::Show

FunctionEnd

Function PageLeaveMPlayerBuild

  ${NSD_FreeIcon} $7zIcon_Handle

  ${NSD_GetState} $MPlayer_Choice1 $MPlayer_Choice1_State
  ${NSD_GetState} $MPlayer_Choice2 $MPlayer_Choice2_State
  ${NSD_GetState} $MPlayer_Choice3 $MPlayer_Choice3_State

  ${If} $MPlayer_Choice1_State = 1
    StrCpy $MPlayer_Selection_State 1
	${ElseIf} $MPlayer_Choice2_State = 1
    StrCpy $MPlayer_Selection_State 2
	${ElseIf} $MPlayer_Choice3_State = 1
    StrCpy $MPlayer_Selection_State 3
	${EndIf}

FunctionEnd
!endif

;--------------------------------
;Installer Sections

Section -SMPlayer

  SetOutPath "$INSTDIR"
!ifndef WITH_MULTIMP
  File /r /x *.bak "smplayer-build\*.*"
!else ifdef WITH_MULTIMP
  AddSize -31400

  File /r /x *.bak /x mplayer.exe "smplayer-build\*.*"

  SetOutPath "$INSTDIR\mplayer"
  ${If} $MPlayer_Selection_State == 1
    File "smplayer-build\mplayer\mplayer.exe"
  ${ElseIf} $MPlayer_Selection_State == 2
    File /oname=mplayer.exe "mplayer-mt\mplayer-amdmt.exe"
  ${ElseIf} $MPlayer_Selection_State == 3
    File /oname=mplayer.exe "mplayer-mt\mplayer-p4mt.exe"
  ${EndIf}
!endif

  SetAutoClose true

SectionEnd