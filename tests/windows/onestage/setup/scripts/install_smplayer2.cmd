@echo off

:: Read from generated file during compile if exist

if exist win32inst_vars.cmd (

  call win32inst_vars.cmd

) else (

echo This batch file can help you to create a directory with all required files
echo Just change the variables at the beginning
echo.
echo Warning: it will only work with sources from the SVN and the command svn has to be in the path
echo.

set /P QT_VER="Qt Version (Default: 4.8.6): "
if "%QT_VER%"=="" set QT_VER=4.8.6

set SMPLAYER_DIR=svn\smplayer
rem set SMTUBE_DIR=svn\smtube
set SMPLAYER_THEMES_DIR=svn\smplayer-themes
set SMPLAYER_SKINS_DIR=svn\smplayer-skins
set QT_DIR=C:\Qt\%QT_VER%
rem set QT_VER=
set MINGW_DIR=
set X86_64=
set BUILD_PREFIX=..
set DEBUG=

)

if [%X86_64%]==[yes] (
  set OUTPUT_DIR=%BUILD_PREFIX%\smplayer-build64
  set OPENSSL_DIR=openssl64
) else (
  set OUTPUT_DIR=%BUILD_PREFIX%\smplayer-build
  set OPENSSL_DIR=openssl
)

if [%DEBUG%]==[yes] (
  set QT_DEBUG_DLL_SUFFIX=d
  set QT_BUILD_DIR=debug
) else (
  set QT_DEBUG_DLL_SUFFIX=
  set QT_BUILD_DIR=release
)

:: Dangerous
REM if exist %OUTPUT_DIR% (
REM  rd /s %OUTPUT_DIR%
REM (

:begin
echo.
echo --      SMPlayer, QT libs      --
echo.

mkdir %OUTPUT_DIR%
copy "%SMPLAYER_DIR%\src\%QT_BUILD_DIR%\smplayer.exe" "%OUTPUT_DIR%"
copy "%SMPLAYER_DIR%\dxlist\release\dxlist.exe" "%OUTPUT_DIR%"
copy "%SMPLAYER_DIR%\zlib\zlib1.dll" "%OUTPUT_DIR%"
copy "%SMPLAYER_DIR%\*.txt" "%OUTPUT_DIR%"
copy "%SMPLAYER_DIR%\setup\sample.avi" "%OUTPUT_DIR%"

:: Core files
if %QT_VER% lss 5.0.0 (

  copy "%QT_DIR%\bin\QtCore%QT_DEBUG_DLL_SUFFIX%4.dll" "%OUTPUT_DIR%"
  copy "%QT_DIR%\bin\QtGui%QT_DEBUG_DLL_SUFFIX%4.dll" "%OUTPUT_DIR%"
  copy "%QT_DIR%\bin\QtNetwork%QT_DEBUG_DLL_SUFFIX%4.dll" "%OUTPUT_DIR%"
  copy "%QT_DIR%\bin\QtXml%QT_DEBUG_DLL_SUFFIX%4.dll" "%OUTPUT_DIR%"
  copy "%QT_DIR%\bin\QtScript%QT_DEBUG_DLL_SUFFIX%4.dll" "%OUTPUT_DIR%"

) else if %QT_VER% geq 5.0.0 (

  copy "%QT_DIR%\bin\icudt*.dll" "%OUTPUT_DIR%"
  copy "%QT_DIR%\bin\icuin*.dll" "%OUTPUT_DIR%"
  copy "%QT_DIR%\bin\icuuc*.dll" "%OUTPUT_DIR%"
  copy "%QT_DIR%\bin\Qt5Core%QT_DEBUG_DLL_SUFFIX%.dll" "%OUTPUT_DIR%"
  copy "%QT_DIR%\bin\Qt5Gui%QT_DEBUG_DLL_SUFFIX%.dll" "%OUTPUT_DIR%"
  copy "%QT_DIR%\bin\Qt5Network%QT_DEBUG_DLL_SUFFIX%.dll" "%OUTPUT_DIR%"
  copy "%QT_DIR%\bin\Qt5Widgets%QT_DEBUG_DLL_SUFFIX%.dll" "%OUTPUT_DIR%"
  copy "%QT_DIR%\bin\Qt5Xml%QT_DEBUG_DLL_SUFFIX%.dll" "%OUTPUT_DIR%"
  copy "%QT_DIR%\bin\Qt5Script%QT_DEBUG_DLL_SUFFIX%.dll" "%OUTPUT_DIR%"

)
:: Qt Plugins
mkdir "%OUTPUT_DIR%\imageformats"
if %QT_VER% lss 5.0.0 (

  copy "%QT_DIR%\plugins\imageformats\qjpeg%QT_DEBUG_DLL_SUFFIX%4.dll" "%OUTPUT_DIR%\imageformats\"

) else if %QT_VER% geq 5.0.0 (

  mkdir "%OUTPUT_DIR%\platforms"
  copy "%QT_DIR%\plugins\imageformats\qjpeg%QT_DEBUG_DLL_SUFFIX%.dll" "%OUTPUT_DIR%\imageformats\"
  copy "%QT_DIR%\plugins\platforms\qwindows%QT_DEBUG_DLL_SUFFIX%.dll" "%OUTPUT_DIR%\platforms\"

)

:: Toolchain specific files
copy "%QT_DIR%\bin\mingwm10.dll" "%OUTPUT_DIR%"
copy "%QT_DIR%\bin\libgcc_s_*.dll" "%OUTPUT_DIR%"
copy "%QT_DIR%\bin\libstdc++-6.dll" "%OUTPUT_DIR%"
copy "%QT_DIR%\bin\libwinpthread-1.dll" "%OUTPUT_DIR%"

copy "%OPENSSL_DIR%\*.dll" "%OUTPUT_DIR%"

echo.
echo --           Fonts             --
echo.
mkdir "%OUTPUT_DIR%\open-fonts"
copy "open-fonts\*.*" "%OUTPUT_DIR%\open-fonts\"

echo.
echo --        Translations         --
echo.
mkdir "%OUTPUT_DIR%\translations"
copy "%SMPLAYER_DIR%\src\translations\*.qm" "%OUTPUT_DIR%\translations"

echo.
echo --       Qt Translations       --
echo.
copy "%QT_DIR%\translations\qt_*.qm" %OUTPUT_DIR%\translations
copy "%SMPLAYER_DIR%\qt-translations\qt_*.qm" "%OUTPUT_DIR%\translations"
del "%OUTPUT_DIR%\translations\qt_help_*.qm"

echo.
echo --         Shortcuts           --
echo.
mkdir "%OUTPUT_DIR%\shortcuts"
copy "%SMPLAYER_DIR%\src\shortcuts\*.keys" "%OUTPUT_DIR%\shortcuts"

echo.
echo --        Documentation        --
echo.
svn export --force "%SMPLAYER_DIR%\docs" "%OUTPUT_DIR%\docs"

echo.
echo --         Icon Themes         --
echo.
for /f "tokens=*" %%a in ('dir /ad /b ^"%SMPLAYER_THEMES_DIR%\themes^"') do (
xcopy "%SMPLAYER_THEMES_DIR%\themes\%%a\*.rcc" "%OUTPUT_DIR%\themes\%%a\"
xcopy "%SMPLAYER_THEMES_DIR%\themes\%%a\README.txt" "%OUTPUT_DIR%\themes\%%a\"
)

echo.
echo --            Skins            --
echo.
for /f "tokens=*" %%b in ('dir /ad /b ^"%SMPLAYER_SKINS_DIR%\themes^"') do (
xcopy "%SMPLAYER_SKINS_DIR%\themes\%%b\*.rcc" "%OUTPUT_DIR%\themes\%%b\"
xcopy "%SMPLAYER_SKINS_DIR%\themes\%%b\main.css" "%OUTPUT_DIR%\themes\%%b\"
)

echo.
echo --           MPlayer           --
echo.
mklink /D "%OUTPUT_DIR%\mplayer" "%BUILD_PREFIX%\mplayer"

echo.

:end

set SMPLAYER_DIR=
set SMTUBE_DIR=
set SMPLAYER_THEMES_DIR=
set SMPLAYER_SKINS_DIR=
set MPLAYER_DIR=
set QT_DIR=
set QT_VER=
set MINGW_DIR=
set X86_64=
set BUILD_PREFIX=

set QT_DEBUG_DLL_SUFFIX=
set QT_BUILD_DIR=
