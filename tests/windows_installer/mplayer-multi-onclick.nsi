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

Var BUTTON_MPLAYER_CHOICE1
Var BUTTON_MPLAYER_CHOICE2
Var BUTTON_MPLAYER_CHOICE3
Var MPBUILD_DESC
Var MPLAYER_SELECTION_STATE
Var MPLAYER_VERSION

;--------------------------------

!define MUI_COMPONENTSPAGE_SMALLDESC

; Pages

!insertmacro MUI_PAGE_DIRECTORY
Page custom PageMPlayerBuild PageLeaveMPlayerBuild
!insertmacro MUI_PAGE_COMPONENTS
!insertmacro MUI_PAGE_INSTFILES

;--------------------------------

!insertmacro MUI_LANGUAGE "English"
!insertmacro MUI_LANGUAGE "Spanish"

Function .onInit

  !insertmacro MUI_LANGDLL_DISPLAY

FunctionEnd

Function PageMPlayerBuild

  nsDialogs::Create /NOUNLOAD 1018
  Pop $0

  !insertmacro MUI_HEADER_TEXT "Choose MPlayer Build" "Choose which MPlayer build you would like to install."
  ${NSD_CreateLabel} 0 0 100% 10u "Select the MPlayer build you would like to install and click Next to continue."

  ${NSD_CreateRadioButton} 10 35 100% 10u "Runtime CPU Detection (Generic)"
  Pop $BUTTON_MPLAYER_CHOICE1
  ${NSD_AddStyle} $BUTTON_MPLAYER_CHOICE1 ${WS_GROUP}
  ${NSD_CreateRadioButton} 10 60 100% 10u "AMD Multi-Core (X2/X3/X4/Phenom)"
  Pop $BUTTON_MPLAYER_CHOICE2
  ${NSD_CreateRadioButton} 10 85 100% 10u "Intel Multi-Core (P4EE/P4D/Xeon/Core2/i7/etc)"
  Pop $BUTTON_MPLAYER_CHOICE3

  ${NSD_CreateGroupBox} 10 171 436 35u $(MUI_INNERTEXT_COMPONENTS_DESCRIPTION_TITLE)
  ${NSD_CreateLabel} 20 191 421 20u
  Pop $MPBUILD_DESC

  ${NSD_OnClick} $BUTTON_MPLAYER_CHOICE1 UpdateDesc
  ${NSD_OnClick} $BUTTON_MPLAYER_CHOICE2 UpdateDesc
  ${NSD_OnClick} $BUTTON_MPLAYER_CHOICE3 UpdateDesc

  /*
  ${NSD_CreateLabel} 26 160 100% 20u "Optimized for multi-core Intel processors using the experimental multithreaded$\n\
  FFmpeg-mt branch for optimal high definition video playback."
  ${NSD_CreateLabel} 26 105 100% 20u "Optimized for multi-core AMD processors using the experimental multithreaded$\n\
  FFmpeg-mt branch for optimal high definition video playback."
  ${NSD_CreateLabel} 26 50 100% 20u "Generic build for all x86/x86-64 CPUs using runtime cpudetection, performance$\n\
  may be limited. If you are unsure, select this build."*/

  ${If} $MPLAYER_SELECTION_STATE = 1
    SendMessage $BUTTON_MPLAYER_CHOICE1 ${BM_SETCHECK} 1 0
  ${ElseIf} $MPLAYER_SELECTION_STATE = 2
    SendMessage $BUTTON_MPLAYER_CHOICE2 ${BM_SETCHECK} 1 0
  ${ElseIf} $MPLAYER_SELECTION_STATE = 3
    SendMessage $BUTTON_MPLAYER_CHOICE3 ${BM_SETCHECK} 1 0
  ${Else}
    SendMessage $BUTTON_MPLAYER_CHOICE1 ${BM_SETCHECK} 1 0
  ${EndIf}

  Call UpdateDesc

  nsDialogs::Show

FunctionEnd

Function UpdateDesc

  ${NSD_GetState} $BUTTON_MPLAYER_CHOICE1 $R0
  ${NSD_GetState} $BUTTON_MPLAYER_CHOICE2 $R1
  ${NSD_GetState} $BUTTON_MPLAYER_CHOICE3 $R2

  ${If} $R0 == 1
    ${NSD_SetText} $MPBUILD_DESC "Generic build for all x86/x86-64 CPUs using runtime cpudetection, performance may be limited. If you are unsure, select this build."
  ${ElseIf} $R1 == 1
    ${NSD_SetText} $MPBUILD_DESC "Optimized for multi-core AMD processors using the multithreaded FFmpeg-mt branch for optimal high definition video playback."
  ${ElseIf} $R2 == 1
    ${NSD_SetText} $MPBUILD_DESC "Optimized for multi-core Intel processors using the multithreaded FFmpeg-mt branch for optimal high definition video playback."
  ${EndIf}

FunctionEnd

Function PageLeaveMPlayerBuild

  ${NSD_GetState} $BUTTON_MPLAYER_CHOICE1 $R0
  ${NSD_GetState} $BUTTON_MPLAYER_CHOICE2 $R1
  ${NSD_GetState} $BUTTON_MPLAYER_CHOICE3 $R2

  ${If} $R0 = 1
    StrCpy $MPLAYER_VERSION "mplayer-svn-30815"
    StrCpy $MPLAYER_SELECTION_STATE 1
	${ElseIf} $R1 = 1
	  StrCpy $MPLAYER_VERSION "mplayer-amd-30815-mt"
    StrCpy $MPLAYER_SELECTION_STATE 2
	${ElseIf} $R2 = 1
    StrCpy $MPLAYER_VERSION "mplayer-intel-30815-mt"
    StrCpy $MPLAYER_SELECTION_STATE 3
	${EndIf}

FunctionEnd

; The stuff to install
Section "MPlayer"

  ; Set output path to the installation directory.
  DetailPrint "$R0 $R1 $R2"
  DetailPrint "MPLAYER_VERSION: $MPLAYER_VERSION"
  DetailPrint "MPLAYER_SELECTION_STATE: $MPLAYER_SELECTION_STATE"
  
SectionEnd ; end the section
