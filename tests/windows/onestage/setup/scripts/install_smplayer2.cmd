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

set /P QTVER="Qt Version (Default: 4.8.4): "
if "%QTVER%"=="" set QTVER=4.8.4

set SMPLAYER_DIR=svn\smplayer
set SMTUBE_DIR=svn\smtube
set SMPLAYER_THEMES_DIR=svn\smplayer-themes
set SMPLAYER_SKINS_DIR=svn\smplayer-skins
set MPLAYER_DIR=mplayer
rem set QT_DIR=C:\QtSDK\Desktop\Qt\%QTVER%\mingw
set QT_DIR=C:\Qt\%QTVER%

)

if [%X86_64%]==[yes] (
  set OUTPUT_DIR=%BUILD_PREFIX%\smplayer-build64
) else (
  set OUTPUT_DIR=%BUILD_PREFIX%\smplayer-build
)

:: MPlayer files
set MPLAYER_DIR=..\mplayer

if exist %OUTPUT_DIR% (
  rd /s %OUTPUT_DIR%
)

:begin
echo.
echo --      SMPlayer, QT libs      --
echo.

mkdir %OUTPUT_DIR%
copy %SMPLAYER_DIR%\src\release\smplayer.exe %OUTPUT_DIR%
copy %SMPLAYER_DIR%\zlib\zlib1.dll %OUTPUT_DIR%
copy %SMPLAYER_DIR%\*.txt %OUTPUT_DIR%
copy %SMPLAYER_DIR%\setup\sample.avi %OUTPUT_DIR%
copy %QT_DIR%\bin\QtCore4.dll %OUTPUT_DIR%
copy %QT_DIR%\bin\QtGui4.dll %OUTPUT_DIR%
copy %QT_DIR%\bin\QtNetwork4.dll %OUTPUT_DIR%
copy %QT_DIR%\bin\QtXml4.dll %OUTPUT_DIR%

if [%X86_64%]==[yes] (

  copy %SMPLAYER_DIR%\dxlist\release\dxlist64.exe %OUTPUT_DIR%\dxlist.exe
  rem copy %MINGW_DIR%\bin\libwinpthread-1.dll %OUTPUT_DIR%

) else (

  copy %SMPLAYER_DIR%\dxlist\release\dxlist.exe %OUTPUT_DIR%
  copy %QT_DIR%\bin\mingwm10.dll %OUTPUT_DIR%
  copy %QT_DIR%\bin\libgcc_s_dw2-1.dll %OUTPUT_DIR%

)

mkdir %OUTPUT_DIR%\imageformats
copy %QT_DIR%\plugins\imageformats\qjpeg4.dll %OUTPUT_DIR%\imageformats\

echo.
echo --        Translations         --
echo.

mkdir %OUTPUT_DIR%\translations
copy %SMPLAYER_DIR%\src\translations\*.qm %OUTPUT_DIR%\translations

echo.
echo --       Qt Translations       --
echo.
copy %QT_DIR%\translations\qt_*.qm %OUTPUT_DIR%\translations
copy %SMPLAYER_DIR%\qt-translations\qt_*.qm %OUTPUT_DIR%\translations
del %OUTPUT_DIR%\translations\qt_help_*.qm

echo.
echo --         Shortcuts           --
echo.
mkdir %OUTPUT_DIR%\shortcuts
copy %SMPLAYER_DIR%\src\shortcuts\*.keys %OUTPUT_DIR%\shortcuts

echo.
echo --        Documentation        --
echo.
svn export --force %SMPLAYER_DIR%\docs %OUTPUT_DIR%\docs

echo.
echo --         Icon Themes         --
echo.
svn export --force %SMPLAYER_THEMES_DIR%\themes %OUTPUT_DIR%\themes

echo.
echo --            Skins            --
echo.
svn export --force %SMPLAYER_SKINS_DIR%\themes %OUTPUT_DIR%\themes

echo.
echo --           SMTube            --
echo.
copy %SMTUBE_DIR%\src\release\smtube.exe %OUTPUT_DIR%
copy %SMTUBE_DIR%\src\translations\*.qm %OUTPUT_DIR%\translations
mkdir %OUTPUT_DIR%\docs\smtube
copy %SMTUBE_DIR%\*.txt %OUTPUT_DIR%\docs\smtube

echo.
echo --           MPlayer           --
echo.
mklink /D %OUTPUT_DIR%\mplayer %MPLAYER_DIR%

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
