;Installer script for win32/win64 SMPlayer
;Written by redxii (redxii@users.sourceforge.net)
;Tested/Developed with Unicode NSIS 2.46.5

!define VER_MAJOR 1
!define VER_MINOR 2
!define VER_BUILD 3

!ifndef VER_MAJOR | VER_MINOR | VER_BUILD
  !error "Version information not defined (or incomplete). You must define: VER_MAJOR, VER_MINOR, VER_BUILD."
!endif

!ifdef WIN64
  !define DISABLE_CODECS
!endif

;--------------------------------
;Compressor

  SetCompressor /SOLID lzma
  SetCompressorDictSize 32

;--------------------------------
;Additional plugin folders

  !addplugindir .
  !addincludedir .

;--------------------------------
;Defines

!ifdef VER_REVISION
  !define SMPLAYER_VERSION "${VER_MAJOR}.${VER_MINOR}.${VER_BUILD}.${VER_REVISION}"
  !define SMPLAYER_PRODUCT_VERSION "${VER_MAJOR}.${VER_MINOR}.${VER_BUILD}.${VER_REVISION}"
!else ifndef VER_REVISION
  !define SMPLAYER_VERSION "${VER_MAJOR}.${VER_MINOR}.${VER_BUILD}"
  !define SMPLAYER_PRODUCT_VERSION "${VER_MAJOR}.${VER_MINOR}.${VER_BUILD}.0"
!endif

!ifdef WIN64
  !define SMPLAYER_BUILD_DIR "smplayer-build64"
!else
  !define SMPLAYER_BUILD_DIR "smplayer-build"
!endif

;--------------------------------
;General

  ;Name and file
  Name "SMPlayer Portable ${SMPLAYER_VERSION}"
  BrandingText "SMPlayer for Windows v${SMPLAYER_VERSION} (Portable Edition)"
!ifdef WIN64
  OutFile "smplayer-portable-${SMPLAYER_VERSION}-x64.exe"
!else
  OutFile "smplayer-portable-${SMPLAYER_VERSION}-win32.exe"
!endif

  ;Version tab properties
  VIProductVersion "${SMPLAYER_PRODUCT_VERSION}"
  VIAddVersionKey "ProductName" "SMPlayer"
  VIAddVersionKey "ProductVersion" "${SMPLAYER_VERSION}"
  VIAddVersionKey "FileVersion" "${SMPLAYER_VERSION}"
  VIAddVersionKey "LegalCopyright" ""
!ifdef WIN64
  VIAddVersionKey "FileDescription" "SMPlayer Portable SFX (64-bit)"
!else
  VIAddVersionKey "FileDescription" "SMPlayer Portable SFX (32-bit)"
!endif

  ;Default installation folder
  InstallDir "$EXEDIR\smplayer-portable-${SMPLAYER_VERSION}"

  ;Get installation folder from registry if available
  InstallDirRegKey HKLM "${SMPLAYER_REG_KEY}" "Path"

  ;Vista+ XML manifest, does not affect older OSes
  RequestExecutionLevel user

  ShowInstDetails show
  ShowUnInstDetails show

;--------------------------------
;Variables

  Var CleanInst
  Var FreeSpace
  Var InstallDirectory
  Var NextButton
  Var InstallDirBox
  Var InstallDirBox_State
  Var BrowseBtn
  Var hCtl__1_GroupBox1
  Var RootDir
  Var RootDirLen
  Var SpaceReq
  Var SecSize

;--------------------------------
;Interface Settings

  ;Installer/Uninstaller icons
  !define MUI_ICON "smplayer-orange-installer.ico"

  ;Misc
  !define MUI_WELCOMEFINISHPAGE_BITMAP "smplayer-orange-wizard.bmp"
  !define MUI_ABORTWARNING

  ;Welcome page
  !define MUI_WELCOMEPAGE_TITLE $(WelcomePage_Title)
  !define MUI_WELCOMEPAGE_TEXT $(WelcomePage_Text)

  ;License page
  !define MUI_LICENSEPAGE_RADIOBUTTONS


;--------------------------------
;Include Modern UI and functions

  !include MUI2.nsh
  !include FileFunc.nsh
  !include Memento.nsh
  !include nsDialogs.nsh
  !include Sections.nsh
  !include WinVer.nsh
  !include WordFunc.nsh
  !include x64.nsh

;--------------------------------
;Pages

  ;Install pages
  #Welcome
  #!insertmacro MUI_PAGE_WELCOME

  #License
  !insertmacro MUI_PAGE_LICENSE "license.txt"
  #!insertmacro MUI_PAGE_DIRECTORY
  #Upgrade/Reinstall
  Page custom InstallDirectory InstallDirectoryLeave
  #Install Directory

  !insertmacro MUI_PAGE_INSTFILES


;--------------------------------
;Languages

  !insertmacro MUI_LANGUAGE "English"
/*  !insertmacro MUI_LANGUAGE "Basque"
  !insertmacro MUI_LANGUAGE "Catalan"
  !insertmacro MUI_LANGUAGE "Croatian"
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
  !insertmacro MUI_LANGUAGE "PortugueseBR"
  !insertmacro MUI_LANGUAGE "Russian"
  !insertmacro MUI_LANGUAGE "SimpChinese"
  !insertmacro MUI_LANGUAGE "Slovak"
  !insertmacro MUI_LANGUAGE "Slovenian"
  !insertmacro MUI_LANGUAGE "Spanish"
  !insertmacro MUI_LANGUAGE "Thai"
  !insertmacro MUI_LANGUAGE "TradChinese"

;Custom translations for setup
*/
  !insertmacro LANGFILE_INCLUDE "translations\english.nsh"
/*  !insertmacro LANGFILE_INCLUDE "translations\basque.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\catalan.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\croatian.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\czech.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\danish.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\dutch.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\finnish.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\french.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\german.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\hebrew.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\hungarian.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\italian.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\japanese.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\korean.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\norwegian.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\polish.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\portuguese.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\portuguesebrazil.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\russian.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\simpchinese.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\slovak.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\slovenian.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\spanish.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\thai.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\tradchinese.nsh"*/

;--------------------------------
;Reserve Files

  ;These files should be inserted before other files in the data block
  ;Keep these lines before any File command
  ;Only for solid compression (by default, solid compression is enabled for BZIP2 and LZMA)

  !insertmacro MUI_RESERVEFILE_LANGDLL
  ReserveFile "${NSISDIR}\Plugins\UserInfo.dll"
  ReserveFile "${NSISDIR}\Plugins\nsDialogs.dll"
  ReserveFile "${NSISDIR}\Plugins\Math.dll"
  ReserveFile "${NSISDIR}\Plugins\System.dll"

;--------------------------------
;Installer Sections

;--------------------------------
;Main SMPlayer files
Section MainFiles SecMain

  SetOutPath "$INSTDIR"
  File /r "test.txt"

SectionEnd

;--------------------------------
;Shared functions

;--------------------------------
;Installer functions



Function .onInit


FunctionEnd


Function InstallDirectory

  nsDialogs::Create /NOUNLOAD 1018
  Pop $InstallDirectory

  nsDialogs::SetRTL $(^RTL)

  GetDlgItem $NextButton $HWNDPARENT 1 ; next=1, cancel=2, back=315
  !insertmacro MUI_HEADER_TEXT "Choose Install Directory" "Choose the folder in which to extract $(^NameDA)."

  ${NSD_CreateLabel} 0 0 100% 16u "Setup will extract $(^NameDA) in the following folder. To extract to a different folder, click Browse and select another folder. $_CLICK"
  ${NSD_CreateGroupBox} 0u 30u 100% 35u "Destination Folder"
  Pop $hCtl__1_GroupBox1
  
  ${NSD_CreateText} 10u 45u 210u 12u "$INSTDIR"
  Pop $InstallDirBox
  
  ; === Browse (type: Button) ===
  ${NSD_CreateButton} 228u 43u 60u 15u $(^BrowseBtn)
  Pop $BrowseBtn

  ${NSD_CreateCheckBox} 0 75u 100% 8u "Reset my SMPlayer configuration"
  Pop $CleanInst

  ${NSD_CreateLabel} 0 115u 100% 8u ""
  Pop $SpaceReq

  ${NSD_CreateLabel} 0 125u 100% 8u ""
  Pop $FreeSpace

  ${NSD_OnClick} $Browsebtn SelectDirectory
  ${NSD_OnChange} $InstallDirBox VerifyDir

  Call UpdateFreeSpace
  Call UpdateReqSpace

  nsDialogs::Show

FunctionEnd

Function SelectDirectory

  nsDialogs::SelectFolderDialog $(^DirBrowseText) "$EXEDIR"
  Pop $InstallDirBox_State
  ${Unless} $InstallDirBox_State == "error"
    StrLen $4 $InstallDirBox_State
    ${If} $4 < 4
      ${NSD_SetText} $InstallDirBox "$InstallDirBox_Statesmplayer-portable-${SMPLAYER_VERSION}"
    ${Else}
      ${NSD_SetText} $InstallDirBox "$InstallDirBox_State\smplayer-portable-${SMPLAYER_VERSION}"
    ${EndIf}
  ${EndIf}

  Call UpdateFreeSpace

FunctionEnd


Function VerifyDir

  ${NSD_GetText} $InstallDirBox $0
  ${GetRoot} "$0" $RootDir
  StrLen $RootDirLen $0

  ${If} $RootDir == ""
    EnableWindow $NextButton 0
  ${Else}
    ${If} $RootDirLen < 4
      EnableWindow $NextButton 0
    ${Else}
      EnableWindow $NextButton 1
    ${EndIf}
  ${EndIf}

  Call UpdateFreeSpace

FunctionEnd

Function UpdateFreeSpace

  ${NSD_GetText} $InstallDirBox $0
  ${GetRoot} "$0" $RootDir
  StrLen $RootDirLen $0

  ${DriveSpace} $RootDir "/D=F /S=M" $6

  ${IfNot} $6 == ""
  ${AndIfNot} $6 == 0
  ${AndIf} $RootDirLen >= 4
    EnableWindow $NextButton 1
  ${Else}
    EnableWindow $NextButton 0
    SendMessage $FreeSpace ${WM_SETTEXT} 0 ""
  ${EndIf}

  ${IfNot} $RootDir == ""
  ${AndIfNot} $6 == ""
  ${AndIfNot} $6 == 0
    SendMessage $FreeSpace ${WM_SETTEXT} 0 "STR:Space available: $6 MB"
  ${EndIf}

FunctionEnd

Function UpdateReqSpace

  SectionGetSize ${SecMain} $SecSize
  IntOp $SecSize $SecSize * 1024

  StrCpy $9 " bytes"

  ${If} $SecSize > 1024
  ${OrIf} $SecSize < 0
    System::Int64Op $SecSize / 1024
    Pop $SecSize
    StrCpy $9 " KB"
    ${If} $SecSize > 1024
    ${OrIf} $SecSize < 0
      System::Int64Op $SecSize / 1024
      Pop $SecSize
      StrCpy $9 " MB"
      ${If} $SecSize > 1024
      ${OrIf} $SecSize < 0
        System::Int64Op $SecSize / 1024
        Pop $SecSize
        StrCpy $9 " GB"
      ${EndIf}
    ${EndIf}
  ${EndIf}

   SendMessage $SpaceReq ${WM_SETTEXT} 0 "STR:Space required: $SecSize$9"

FunctionEnd

Function InstallDirectoryLeave

  ${NSD_GetText} $InstallDirBox $INSTDIR

FunctionEnd
