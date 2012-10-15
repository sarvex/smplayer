@echo off
echo This batch file can help you to create a directory with all required files
echo Just change the variables at the beginning
echo.
echo Warning: it will only work with sources from the SVN and the command svn has to be in the path
echo.

set /P QTVER="Qt Version (Default: 4.7.4): "
if "%QTVER%"=="" set QTVER=4.7.4

set OUTPUT_DIR=umplayer-build

set UMPLAYER_DIR=svn\umplayer
set UMPLAYER_THEMES_DIR=svn\umplayer\src\themes
set MPLAYER_DIR=mplayer
set QT_DIR=C:\QtSDK\Desktop\Qt\%QTVER%\mingw

echo.
echo ######      SMPlayer, QT libs      #######
echo.

mkdir %OUTPUT_DIR%
copy %UMPLAYER_DIR%\src\release\umplayer.exe %OUTPUT_DIR%
copy %UMPLAYER_DIR%\dxlist\release\dxlist.exe %OUTPUT_DIR%
copy %UMPLAYER_DIR%\zlib\zlib1.dll %OUTPUT_DIR%
copy %UMPLAYER_DIR%\*.txt %OUTPUT_DIR%
copy %QT_DIR%\bin\QtCore4.dll %OUTPUT_DIR%
copy %QT_DIR%\bin\QtGui4.dll %OUTPUT_DIR%
copy %QT_DIR%\bin\QtNetwork4.dll %OUTPUT_DIR%
copy %QT_DIR%\bin\QtXml4.dll %OUTPUT_DIR%
copy %QT_DIR%\bin\mingwm10.dll %OUTPUT_DIR%
if %QTVER% geq 4.6.0 (
copy %QT_DIR%\bin\libgcc_s_dw2-1.dll %OUTPUT_DIR%
)

mkdir %OUTPUT_DIR%\imageformats
copy %QT_DIR%\plugins\imageformats\qjpeg4.dll %OUTPUT_DIR%\imageformats\

echo.
echo ######        Translations         #######
echo.

mkdir %OUTPUT_DIR%\translations
copy %UMPLAYER_DIR%\src\translations\*.qm %OUTPUT_DIR%\translations

echo.
echo ######       Qt Translations       #######
echo.
copy %QT_DIR%\translations\qt_*.qm %OUTPUT_DIR%\translations
del %OUTPUT_DIR%\translations\qt_help_*.qm

echo.
echo ######         Shortcuts           #######
echo.
mkdir %OUTPUT_DIR%\shortcuts
copy %UMPLAYER_DIR%\src\shortcuts\*.keys %OUTPUT_DIR%\shortcuts

echo.
echo ######        Documentation        #######
echo.
svn export --force %UMPLAYER_DIR%\docs %OUTPUT_DIR%\docs

echo.
echo ######         Icon Themes         #######
echo.
svn export --force %UMPLAYER_THEMES_DIR% %OUTPUT_DIR%\themes

echo.
echo ######           MPlayer           #######
echo.
xcopy %MPLAYER_DIR% %OUTPUT_DIR%\mplayer\ /E

echo.
