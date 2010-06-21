; The name of the installer
Name "MPlayer"

; The file to write
OutFile "mp-inst-onclick.exe"

; Request application privileges for Windows Vista
RequestExecutionLevel user

InstallDir "$DESKTOP"

ShowInstDetails show

!include MUI2.nsh
!include LogicLib.nsh
!include nsDialogs.nsh

Var MPlayer_Choice1
Var MPlayer_Choice1_State
Var MPlayer_Choice2
Var MPlayer_Choice2_State
Var MPlayer_Choice3
Var MPlayer_Choice3_State
Var MPBuild_Desc
Var MPlayer_Selection_State
Var MPlayer_Version

;--------------------------------

!define MUI_COMPONENTSPAGE_SMALLDESC

!define MUI_WELCOMEFINISHPAGE_BITMAP "..\smplayer-orange-wizard.bmp"
!define MUI_UNWELCOMEFINISHPAGE_BITMAP "..\smplayer-orange-wizard-un.bmp"

!define MUI_ICON "..\smplayer-orange-installer.ico"
!define MUI_UNICON "..\smplayer-orange-uninstaller.ico"

; Pages
Page custom PageDisclaimer
!insertmacro MUI_PAGE_WELCOME
!insertmacro MUI_PAGE_DIRECTORY
Page custom PageMPlayerBuild PageLeaveMPlayerBuild
!insertmacro MUI_PAGE_COMPONENTS
!insertmacro MUI_PAGE_INSTFILES
!insertmacro MUI_PAGE_FINISH

!insertmacro MUI_UNPAGE_WELCOME
!insertmacro MUI_UNPAGE_CONFIRM
!insertmacro MUI_UNPAGE_INSTFILES
!insertmacro MUI_UNPAGE_FINISH

;--------------------------------

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
!insertmacro MUI_LANGUAGE "Japanese"
!insertmacro MUI_LANGUAGE "Korean"
!insertmacro MUI_LANGUAGE "Norwegian"
!insertmacro MUI_LANGUAGE "Polish"
!insertmacro MUI_LANGUAGE "Portuguese"
!insertmacro MUI_LANGUAGE "Russian"
!insertmacro MUI_LANGUAGE "SimpChinese"
!insertmacro MUI_LANGUAGE "Slovak"
!insertmacro MUI_LANGUAGE "Slovenian"
!insertmacro MUI_LANGUAGE "Spanish"
!insertmacro MUI_LANGUAGE "TradChinese"

Function .onInit

  !insertmacro MUI_LANGDLL_DISPLAY

  StrCpy $MPlayer_Selection_State 2

FunctionEnd

Function PageDisclaimer

  Var /GLOBAL AgreeCheckbox
  Var /GLOBAL AgreeCheckbox_State
  Var /GLOBAL NextButton

  GetDlgItem $NextButton $HWNDPARENT 1
  EnableWindow $NextButton 0

  nsDialogs::Create /NOUNLOAD 1018
  Pop $0

  !insertmacro MUI_HEADER_TEXT "Pre-release Information" "This is a pre-release version of SMPlayer"

  ${NSD_CreateLabel} 0 0 100% 20u "You are about to install a pre-release version of SMPlayer that is only meant to be used for testing purposes."
  ${NSD_CreateLabel} 0 25u 100% 20u "If you have a previous version of SMPlayer installed, you should back up your settings before you continue. If you do not, you may lose them."
  ${NSD_CreateLabel} 0 50u 100% 20u "The latest stable release of SMPlayer can be found on the SMPlayer website, is safer and more reliable, and is recommended for most users."
  ${NSD_CreateLabel} 0 75u 100% 20u "Please report any issues in the SMPlayer forum."
  ${NSD_CreateCheckBox} 0 125u 100% 10u "I understand and would like to continue installing the pre-release version of SMPlayer."
  Pop $AgreeCheckbox
  ${NSD_OnClick} $AgreeCheckbox PageDisclaimerUpdate

  nsDialogs::Show

FunctionEnd

Function PageDisclaimerUpdate

  ${NSD_GetState} $AgreeCheckbox $AgreeCheckbox_State
  ${If} $AgreeCheckbox_State == ${BST_CHECKED}
    EnableWindow $NextButton 1
  ${ElseIf} $AgreeCheckbox_State == ${BST_UNCHECKED}
    EnableWindow $NextButton 0
  ${EndIf}

FunctionEnd

Function PageMPlayerBuild

  nsDialogs::Create /NOUNLOAD 1018
  Pop $1

  ${If} $LANGUAGE == "1037"
    nsDialogs::SetRTL 1
  ${EndIf}

  !insertmacro MUI_HEADER_TEXT "Choose MPlayer Build" "Choose which MPlayer build you would like to install."
  ${NSD_CreateLabel} 0 0 100% 10u "Select an MPlayer build you would like to install. $_CLICK"

  ${NSD_CreateRadioButton} 10 35 100% 10u "Runtime CPU Detection (x86/x86-64 Generic)"
  Pop $MPlayer_Choice1
  ${NSD_AddStyle} $MPlayer_Choice1 ${WS_GROUP}
  ${NSD_CreateRadioButton} 10 60 100% 10u "AMD Multi-Core Processors (X2/X3/X4/Phenom/etc)"
  Pop $MPlayer_Choice2
  ${NSD_CreateRadioButton} 10 85 100% 10u "Intel Multi-Core Processors (P4EE/P4D/Xeon/Core2/i7/etc)"
  Pop $MPlayer_Choice3

  ${NSD_CreateGroupBox} 0u 105u 297u 35u $(MUI_INNERTEXT_COMPONENTS_DESCRIPTION_TITLE)
  ${NSD_CreateLabel} 6u 117u 285u 18u
  Pop $MPBuild_Desc

  ${NSD_OnClick} $MPlayer_Choice1 UpdateDesc
  ${NSD_OnClick} $MPlayer_Choice2 UpdateDesc
  ${NSD_OnClick} $MPlayer_Choice3 UpdateDesc

  ${If} $MPlayer_Selection_State = 1
    SendMessage $MPlayer_Choice1 ${BM_SETCHECK} 1 0
  ${ElseIf} $MPlayer_Selection_State = 2
    SendMessage $MPlayer_Choice2 ${BM_SETCHECK} 1 0
  ${ElseIf} $MPlayer_Selection_State = 3
    SendMessage $MPlayer_Choice3 ${BM_SETCHECK} 1 0
  ${Else}
    SendMessage $MPlayer_Choice1 ${BM_SETCHECK} 1 0
  ${EndIf}

  Call UpdateDesc

  nsDialogs::Show

FunctionEnd

Function UpdateDesc

  ${NSD_GetState} $MPlayer_Choice1 $MPlayer_Choice1_State
  ${NSD_GetState} $MPlayer_Choice2 $MPlayer_Choice2_State
  ${NSD_GetState} $MPlayer_Choice3 $MPlayer_Choice3_State

  ${If} $MPlayer_Choice1_State == 1
    ${NSD_SetText} $MPBuild_Desc "Unoptimized build compatible with all modern 32-bit && 64-bit x86 CPUs. Performance is limited, and cannot fully utilize multi-core CPUs. If you are unsure, select this build."
  ${ElseIf} $MPlayer_Choice2_State == 1
    ${NSD_SetText} $MPBuild_Desc "FFmpeg-mt build optimized to take advantage of multi-core AMD processors for optimal high definition video playback."
  ${ElseIf} $MPlayer_Choice3_State == 1
    ${NSD_SetText} $MPBuild_Desc "FFmpeg-mt build optimized to take advantage of multi-core Intel processors for optimal high definition video playback."
  ${EndIf}

FunctionEnd

Function PageLeaveMPlayerBuild

  ${NSD_GetState} $MPlayer_Choice1 $MPlayer_Choice1_State
  ${NSD_GetState} $MPlayer_Choice2 $MPlayer_Choice2_State
  ${NSD_GetState} $MPlayer_Choice3 $MPlayer_Choice3_State

  ${If} $MPlayer_Choice1_State = 1
    StrCpy $MPlayer_Version "mplayer-svn-30815"
    StrCpy $MPlayer_Selection_State 1
	${ElseIf} $MPlayer_Choice2_State = 1
	  StrCpy $MPlayer_Version "mplayer-amd-30815-mt"
    StrCpy $MPlayer_Selection_State 2
	${ElseIf} $MPlayer_Choice3_State = 1
    StrCpy $MPlayer_Version "mplayer-intel-30815-mt"
    StrCpy $MPlayer_Selection_State 3
	${EndIf}

FunctionEnd

; The stuff to install
Section "MPlayer"

  ; Set output path to the installation directory.
  DetailPrint "$MPlayer_Choice1_State $MPlayer_Choice2_State $MPlayer_Choice3_State"
  DetailPrint "MPlayer_Version: $MPlayer_Version"
  DetailPrint "MPlayer_Selection_State: $MPlayer_Selection_State"
  SetAutoClose false

SectionEnd ; end the section

Section /o Remover

  WriteUninstaller "uninst.exe"

SectionEnd

Section Uninstall

  DetailPrint "Foo!"

SectionEnd
