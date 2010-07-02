; Installer script for win32 SMPlayer Portable Edition
; Written by redxii (redxii@users.sourceforge.net)
; Tested/Developed with Unicode NSIS 2.45.1/2.46

!ifndef VER_MAJOR | VER_MINOR | VER_BUILD
  !error "Version information not defined (or incomplete). You must define: VER_MAJOR, VER_MINOR, VER_BUILD."
!endif

;--------------------------------
;Compressor

  SetCompressor /SOLID lzma
  SetCompressorDictSize 64

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
  BrandingText "SMPlayer v${SMPLAYER_VERSION} SFX"
  OutFile "smplayer-${SMPLAYER_VERSION}-sfx.exe"

  ;Installer/Uninstaller icons
  !define MUI_ICON "7z.ico"

  ;Version tab properties
  VIProductVersion "${SMPLAYER_PRODUCT_VERSION}"
  VIAddVersionKey "ProductName" "SMPlayer SFX/Portable"
  VIAddVersionKey "ProductVersion" "${SMPLAYER_VERSION}"
  VIAddVersionKey "FileVersion" "${SMPLAYER_VERSION}"
  VIAddVersionKey "LegalCopyright" ""
  VIAddVersionKey "FileDescription" "SMPlayer SFX/Portable"

  ;Default extraction folder
  InstallDir ".\smplayer-${SMPLAYER_VERSION}"

  ;Request application privileges for Windows Vista/7
  RequestExecutionLevel user

  ShowInstDetails nevershow

  !include MUI2.nsh
  !include nsDialogs.nsh

  Var 7zIcon
  Var 7zIcon_Handle
  Var InstOpt_Choice1
  Var InstOpt_Choice1_State
  Var InstOpt_Choice2
  Var InstOpt_Choice2_State
  Var Install_MPlayer
  Var Install_Portable
  Var MPlayer_Choice1
  Var MPlayer_Choice1_State
  Var MPlayer_Choice2
  Var MPlayer_Choice2_State
  Var MPlayer_Choice3
  Var MPlayer_Choice3_State
  Var MPlayer_Selection_State

;--------------------------------
;Interface Settings

  Caption "SMPlayer SFX ${SMPLAYER_VERSION}"
  DirText "Select a folder to extract SMPlayer to. $_CLICK" "" "" "Select the folder to extract SMPlayer to:"
  InstallButtonText "Extract"

  !define MUI_UI "${NSISDIR}\Contrib\UIs\sdbarker_tiny.exe" 

;--------------------------------
;Pages

  ;Install pages
  !insertmacro MUI_PAGE_DIRECTORY
  Page custom PageInstOptions PageLeaveInstOptions
  Page custom PageMPlayerBuild PageLeaveMPlayerBuild
  !insertmacro MUI_PAGE_INSTFILES

;--------------------------------
;Languages

  !insertmacro MUI_LANGUAGE "English"

;--------------------------------
;Installer Functions
Function PageInstOptions

  nsDialogs::Create /NOUNLOAD 1018
  Pop $2

  ${NSD_CreateIcon} 0 0 32 32 ""
  Pop $7zIcon
  ${NSD_SetIconFromInstaller} $7zIcon $7zIcon_Handle

  ${NSD_CreateLabel} 25u 0 241u 18u "Select additional options to customize SMPlayer. $_CLICK"

  ${NSD_CreateCheckBox} 25u 25u 150u 10u "Extract Portable Edition"
  Pop $InstOpt_Choice1

  ${NSD_CreateLabel} 25u 37u 150u 10u "Advanced Settings:"
  ${NSD_CreateCheckBox} 25u 48u 150u 10u "Do not extract MPlayer"
  Pop $InstOpt_Choice2

  nsDialogs::Show

  ${NSD_FreeIcon} $7zIcon_Handle

FunctionEnd

Function PageLeaveInstOptions

  ${NSD_GetState} $InstOpt_Choice1 $InstOpt_Choice1_State
  ${NSD_GetState} $InstOpt_Choice2 $InstOpt_Choice2_State

  ${If} $InstOpt_Choice1_State == ${BST_CHECKED}
    StrCpy $Install_Portable 1
  ${Else}
    StrCpy $Install_Portable 0
  ${EndIf}

  ${If} $InstOpt_Choice2_State == ${BST_CHECKED}
    StrCpy $Install_MPlayer 0
  ${Else}
    StrCpy $Install_MPlayer 1
  ${EndIf}

FunctionEnd

Function PageMPlayerBuild

  ${If} $Install_MPlayer == 0
    Abort
  ${EndIf}

  nsDialogs::Create /NOUNLOAD 1018
  Pop $1

  ${NSD_CreateIcon} 0 0 32 32 ""
  Pop $7zIcon
  ${NSD_SetIconFromInstaller} $7zIcon $7zIcon_Handle

  ${NSD_CreateLabel} 25u 0 241u 18u "Select an MPlayer build optimized for your CPU. If you are unsure, select 'Runtime CPU Detection'. Click Extract to continue."

  ${NSD_CreateRadioButton} 25u 25u 200u 10u "Runtime CPU Detection (x86/x86-64 Generic)"
  Pop $MPlayer_Choice1

  ${NSD_CreateRadioButton} 25u 37u 200u 10u "AMD Multi-Core Processors (X2/X3/X4/Phenom/etc)"
  Pop $MPlayer_Choice2

  ${NSD_CreateRadioButton} 25u 48u 200u 10u "Intel Multi-Core Processors (P4EE/P4D/Xeon/Core2/i7/etc)"
  Pop $MPlayer_Choice3

  SendMessage $MPlayer_Choice1 ${BM_SETCHECK} 1 0

  nsDialogs::Show

  ${NSD_FreeIcon} $7zIcon_Handle

FunctionEnd

Function PageLeaveMPlayerBuild

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

;--------------------------------
;Installer Sections

Section -SMPlayer

  AddSize -34000

  SetOutPath "$INSTDIR"
  File /x smplayer.exe "smplayer-build\*"

  ${If} $Install_Portable == 0
    File "smplayer-build\smplayer.exe"
  ${Else}
    File /oname=smplayer.exe "portable\smplayer-portable.exe"
  ${EndIf}

  SetOutPath "$INSTDIR\imageformats"
  File /r "smplayer-build\imageformats\*.*"

  SetOutPath "$INSTDIR\shortcuts"
  File /r "smplayer-build\shortcuts\*.*"

  SetOutPath "$INSTDIR\docs"
  File /r "smplayer-build\docs\*.*"

  SetOutPath "$INSTDIR\themes"
  File /r "smplayer-build\themes\*.*"

  SetOutPath "$INSTDIR\translations"
  File /r "smplayer-build\translations\*.*"

  ${If} $Install_MPlayer != 0

    SetOutPath "$INSTDIR\mplayer"
    File /r /x mplayer.exe "smplayer-build\mplayer\*.*"

    ${If} $MPlayer_Selection_State == 1
      File "smplayer-build\mplayer\mplayer.exe"
    ${ElseIf} $MPlayer_Selection_State == 2
      File /oname=mplayer.exe "mplayer-mt\mplayer-amdmt.exe"
    ${ElseIf} $MPlayer_Selection_State == 3
      File /oname=mplayer.exe "mplayer-mt\mplayer-p4mt.exe"
    ${EndIf}

    ${If} $Install_Portable == 1
      SetOutPath "$INSTDIR\mplayer\fonts"
      File "portable\local.conf"
    ${EndIf}

  ${EndIf}

  SetAutoClose true

SectionEnd