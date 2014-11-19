;Portable script for win32/win64 SMPlayer
;Written by redxii (redxii@users.sourceforge.net)
;Tested/Developed with Unicode NSIS 2.46.5

!ifndef VER_MAJOR | VER_MINOR | VER_BUILD
  !error "Version information not defined (or incomplete). You must define: VER_MAJOR, VER_MINOR, VER_BUILD."
!endif

;--------------------------------
;Compressor

  SetCompressor /SOLID lzma
  SetCompressorDictSize 128

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
  !define SMPLAYER_OUT_DIR "smplayer-portable-${SMPLAYER_VERSION}-x64"
!else
  !define SMPLAYER_BUILD_DIR "smplayer-build"
  !define SMPLAYER_OUT_DIR "smplayer-portable-${SMPLAYER_VERSION}"
!endif

;--------------------------------
;General

  ;Name and file
  Name "SMPlayer Portable ${SMPLAYER_VERSION}"
  BrandingText "SMPlayer for Windows v${SMPLAYER_VERSION} (Portable Edition)"
!ifdef WIN64
  OutFile "output\smplayer-portable-${SMPLAYER_VERSION}-x64.exe"
!else
  OutFile "output\smplayer-portable-${SMPLAYER_VERSION}.exe"
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
  InstallDir "$EXEDIR\${SMPLAYER_OUT_DIR}"

  ;Vista+ XML manifest, does not affect older OSes
  RequestExecutionLevel user

  ShowInstDetails show
  ShowUnInstDetails show

;--------------------------------
;Variables

  Var FreeSpace
  Var InstallDirectory
  Var PerformCleanInstall
  Var PerformCleanInstall_State
  Var NextButton
  Var InstallDirBox
  Var InstallDirBox_State
  Var BrowseBtn
  Var hCtl__1_GroupBox1
  Var RootDir
  Var RootDirFreeSpace
  Var RootDirSlash
  Var SpaceReq
  Var SecSize
  Var SecSizeUnit

  ;StrLen
  Var Len_InstallDirBox_State
  Var Len_RootDir

  ;File
  Var File_Local_Conf
  Var File_Smplayer_Ini
  Var File_Smplayer_Orig_Ini

;--------------------------------
;Interface Settings

  ;Installer/Uninstaller icons
  !define MUI_ICON "smplayer-orange-installer.ico"

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
  !insertmacro MUI_PAGE_LICENSE "license.txt"
  Page custom InstallDirectory InstallDirectoryLeave
  !insertmacro MUI_PAGE_INSTFILES

;--------------------------------
;Languages

  !insertmacro MUI_LANGUAGE "English"
  !insertmacro MUI_LANGUAGE "Basque"
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

  !insertmacro LANGFILE_INCLUDE "translations\english.nsh"
  !insertmacro LANGFILE_INCLUDE "translations\basque.nsh"
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
  !insertmacro LANGFILE_INCLUDE "translations\tradchinese.nsh"

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

  ${If} "$PerformCleanInstall_State" == 1
    ; m3u8
    Delete $INSTDIR\favorites.m3u8
    Delete $INSTDIR\radio.m3u8
    Delete $INSTDIR\tv.m3u8

    ; ini
    Delete $INSTDIR\smplayer.ini
    Delete $INSTDIR\smtube.ini
    Delete $INSTDIR\player_info.ini

    ; misc
    Delete $INSTDIR\styles.ass
    Delete $INSTDIR\yt.js
    Delete $INSTDIR\ytcode.script
    Delete $INSTDIR\fonts.conf

    ; dirs
    RMDir /r $INSTDIR\file_settings
    RMDir /r $INSTDIR\fontconfig
    RMDir /r $INSTDIR\screenshots
  ${EndIf}

  RMDir /r $INSTDIR\docs
  RMDir /r $INSTDIR\imageformats
  RMDir /r $INSTDIR\mplayer
  RMDir /r $INSTDIR\shortcuts
  RMDir /r $INSTDIR\themes
  RMDir /r $INSTDIR\translations

  ; exes
  Delete $INSTDIR\smplayer.exe
  Delete $INSTDIR\smtube.exe
  Delete $INSTDIR\dxlist.exe

  ; dlls
  Delete $INSTDIR\QtCore4.dll
  Delete $INSTDIR\QtGui4.dll
  Delete $INSTDIR\QtNetwork4.dll
  Delete $INSTDIR\QtScript4.dll
  Delete $INSTDIR\QtXml4.dll
  Delete $INSTDIR\Qt5Core.dll
  Delete $INSTDIR\Qt5Gui.dll
  Delete $INSTDIR\Qt5Network.dll
  Delete $INSTDIR\Qt5Widgets.dll
  Delete $INSTDIR\Qt5Xml.dll
  Delete $INSTDIR\Qt5Script.dll

  Delete $INSTDIR\icudt*.dll
  Delete $INSTDIR\icuin*.dll
  Delete $INSTDIR\icuuc*.dll
  Delete $INSTDIR\libeay32.dll
  Delete $INSTDIR\ssleay32.dll

  Delete $INSTDIR\libgcc_s_seh-1.dll
  Delete $INSTDIR\libgcc_s_dw2-1.dll
  Delete $INSTDIR\libstdc++-6.dll
  Delete $INSTDIR\libwinpthread-1.dll
  Delete $INSTDIR\mingwm10.dll 
  Delete $INSTDIR\zlib1.dll

  ; misc
  Delete $INSTDIR\Copying.txt
  Delete $INSTDIR\Copying_BSD.txt
  Delete $INSTDIR\Copying_libmaia.txt
  Delete $INSTDIR\Copying_openssl.txt
  Delete $INSTDIR\dvdmenus.txt
  Delete $INSTDIR\Finding_subtitles.txt
  Delete $INSTDIR\Install.txt
  Delete $INSTDIR\Not_so_obvious_things.txt
  Delete $INSTDIR\Notes_about_mpv.txt
  Delete $INSTDIR\Portable_Edition.txt
  Delete $INSTDIR\Readme.txt
  Delete $INSTDIR\Release_notes.txt
  Delete $INSTDIR\sample.avi
  Delete $INSTDIR\smplayer_orig.ini
  Delete $INSTDIR\Watching_TV.txt

  Sleep 100

  SetOutPath "$INSTDIR"
  File /x smplayer.exe /x smtube.exe "${SMPLAYER_BUILD_DIR}\*"
!ifdef WIN64
  File /oname=smplayer.exe "portable\smplayer-portable64.exe"
  File /oname=smtube.exe "portable\smtube-portable64.exe"
!else
  File /oname=smplayer.exe "portable\smplayer-portable.exe"
  File /oname=smtube.exe "portable\smtube-portable.exe"
!endif

  ;SMPlayer docs
  SetOutPath "$INSTDIR\docs"
  File /r "${SMPLAYER_BUILD_DIR}\docs\*.*"

  ;Qt imageformats
  SetOutPath "$INSTDIR\imageformats"
  File /r "${SMPLAYER_BUILD_DIR}\imageformats\*.*"

  ;Qt platforms (Qt 5+)
  SetOutPath "$INSTDIR\platforms"
  File /nonfatal /r "${SMPLAYER_BUILD_DIR}\platforms\*.*"

  ;SMPlayer key shortcuts
  SetOutPath "$INSTDIR\shortcuts"
  File /r "${SMPLAYER_BUILD_DIR}\shortcuts\*.*"

  SetOutPath "$INSTDIR\mplayer"
  File /r /x mplayer.exe /x mencoder.exe /x mplayer64.exe /x mencoder64.exe /x *.exe.debug /x buildinfo /x buildinfo64 "${SMPLAYER_BUILD_DIR}\mplayer\*.*"
!ifdef WIN64
  File /oname=mplayer.exe "${SMPLAYER_BUILD_DIR}\mplayer\mplayer64.exe"
!else
  File "${SMPLAYER_BUILD_DIR}\mplayer\mplayer.exe"
!endif

  SetOutPath "$INSTDIR\themes"
  File /r "${SMPLAYER_BUILD_DIR}\themes\*.*"

  SetOutPath "$INSTDIR\translations"
  File /r "${SMPLAYER_BUILD_DIR}\translations\*.*"

  ;Fontconfig cache folder must be current dir "." otherwise for some reason the
  ;cache is created one level up from the installed directory.
  FileOpen $File_Local_Conf "$INSTDIR\mplayer\fonts\local.conf" w
  FileWrite $File_Local_Conf "<cachedir>./fontconfig</cachedir>$\r$\n"
  FileClose $File_Local_Conf

  ${If} "$PerformCleanInstall_State" == 1
  ${OrIfNot} ${FileExists} "$INSTDIR\smplayer.ini"
    FileOpen $File_Smplayer_Ini "$INSTDIR\smplayer.ini" w
    FileWrite $File_Smplayer_Ini "[%General]$\r$\n"
    FileWrite $File_Smplayer_Ini "screenshot_directory=.\\screenshots$\r$\n$\r$\n"
    FileWrite $File_Smplayer_Ini "[advanced]$\r$\n"
    FileWrite $File_Smplayer_Ini "mplayer_additional_options=-nofontconfig$\r$\n"
    FileClose $File_Smplayer_Ini
  ${EndIf}

  FileOpen $File_Smplayer_Orig_Ini "$INSTDIR\smplayer_orig.ini" w
  FileWrite $File_Smplayer_Orig_Ini "[%General]$\r$\n"
  FileWrite $File_Smplayer_Orig_Ini "screenshot_directory=.\\screenshots$\r$\n$\r$\n"
  FileWrite $File_Smplayer_Orig_Ini "[advanced]$\r$\n"
  FileWrite $File_Smplayer_Orig_Ini "mplayer_additional_options=-nofontconfig$\r$\n"
  FileClose $File_Smplayer_Orig_Ini

  ; Delete empty Qt5 directory when using Qt4
  RMDir $INSTDIR\platforms

SectionEnd

;--------------------------------
;Shared functions

;--------------------------------
;Installer functions

/*Function .onInit

  

FunctionEnd*/


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

  ${NSD_CreateCheckBox} 0 75u 100% 8u $(Reinstall_Msg5)
  Pop $PerformCleanInstall

  ${NSD_CreateLabel} 0 115u 100% 8u ""
  Pop $SpaceReq

  ${NSD_CreateLabel} 0 125u 100% 8u ""
  Pop $FreeSpace

  ${NSD_OnClick} $Browsebtn SelectDirectory
  ${NSD_OnChange} $InstallDirBox UpdateFreeSpace

  Call UpdateFreeSpace
  Call UpdateReqSpace

  nsDialogs::Show

FunctionEnd

Function SelectDirectory

  nsDialogs::SelectFolderDialog $(^DirBrowseText) "$EXEDIR"
  Pop $InstallDirBox_State
  ${Unless} $InstallDirBox_State == "error"
    StrLen $Len_InstallDirBox_State $InstallDirBox_State
    ${If} $Len_InstallDirBox_State < 4
      ${NSD_SetText} $InstallDirBox "$InstallDirBox_State${SMPLAYER_OUT_DIR}"
    ${Else}
      ${NSD_SetText} $InstallDirBox "$InstallDirBox_State\${SMPLAYER_OUT_DIR}"
    ${EndIf}
  ${EndIf}

FunctionEnd

Function UpdateFreeSpace

  ${NSD_GetText} $InstallDirBox $R0
  ${GetRoot} "$R0" $RootDir
  StrCpy $RootDirSlash "$R0" 3
  StrCpy $RootDirSlash "$RootDirSlash" 3 -1
  StrLen $Len_RootDir $R0

  ${DriveSpace} $RootDir "/D=F /S=M" $RootDirFreeSpace

  ${IfNot} $RootDirFreeSpace == ""
  ${AndIfNot} $RootDirFreeSpace == 0
  ${AndIf} $Len_RootDir >= 4
  ${AndIf} $RootDirSlash == "\"
    EnableWindow $NextButton 1
  ${Else}
    EnableWindow $NextButton 0
  ${EndIf}

  ${IfNot} $RootDir == ""
  ${AndIfNot} $RootDirFreeSpace == ""
  ${AndIfNot} $RootDirFreeSpace == 0
    SendMessage $FreeSpace ${WM_SETTEXT} 0 "STR:Space available: $RootDirFreeSpace MB"
  ${Else}
    SendMessage $FreeSpace ${WM_SETTEXT} 0 ""
  ${EndIf}

FunctionEnd

Function UpdateReqSpace

  SectionGetSize ${SecMain} $SecSize
  IntOp $SecSize $SecSize * 1024

  StrCpy $SecSizeUnit " bytes"

  ${If} $SecSize > 1023
  ${OrIf} $SecSize < 0
    System::Int64Op $SecSize / 1024
    Pop $SecSize
    StrCpy $SecSizeUnit " KB"
    ${If} $SecSize > 1024
    ${OrIf} $SecSize < 0
      System::Int64Op $SecSize / 1024
      Pop $SecSize
      StrCpy $SecSizeUnit " MB"
      ${If} $SecSize > 1024
      ${OrIf} $SecSize < 0
        System::Int64Op $SecSize / 1024
        Pop $SecSize
        StrCpy $SecSizeUnit " GB"
      ${EndIf}
    ${EndIf}
  ${EndIf}

   SendMessage $SpaceReq ${WM_SETTEXT} 0 "STR:Space required: $SecSize$SecSizeUnit"

FunctionEnd

Function InstallDirectoryLeave

  ${NSD_GetText} $InstallDirBox $INSTDIR
  ${NSD_GetState} $PerformCleanInstall $PerformCleanInstall_State

FunctionEnd
