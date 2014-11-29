@setlocal enableextensions
@cd /d "%~dp0"

@echo off
echo This batch file can help you to create a packages for SMPlayer and MPV.
echo.
echo Note: It will temporarily rename the smplayer-build or mplayer directory.
echo Be sure to have a compiled portable smplayer.exe, renamed as
echo `smplayer-portable.exe` in the same directory as this script or an
echo alternate location you specify in this script when creating the portable
echo packages.
echo.
echo Configure your build environment at the beginning of this script.
echo.
echo 7zip command-line (http://7zip.org) is required by this script.
echo.
rem echo 1 - NSIS                          10 - NSIS [32-bit/64-bit]
rem echo 2 - NSIS [64-bit]                 11 - Portable [32-bit/64-bit]
echo 3 - Portable
echo 4 - Portable [64-bit]
echo.

:: Relative directory of all the source files to this script
set TOP_LEVEL_DIR=..

:: Reset in case ran again in same command prompt instance
set ALL_PKG_VER=
set VER_MAJOR=
set VER_MINOR=
set VER_BUILD=
set VER_REVISION=
set VER_REV_CMD=
set MAKENSIS_EXE_PATH=
set USER_CHOICE=

:: NSIS path
if exist "%PROGRAMFILES(X86)%\NSIS\Unicode\makensis.exe" (
  set MAKENSIS_EXE_PATH="%PROGRAMFILES(X86)%\NSIS\Unicode\makensis.exe"
) else if exist "%PROGRAMFILES%\NSIS\Unicode\makensis.exe" (
  set MAKENSIS_EXE_PATH="%PROGRAMFILES%\NSIS\Unicode\makensis.exe"
)

set SMPLAYER_DIR=%TOP_LEVEL_DIR%\smplayer-build
set SMPLAYER_DIR64=%TOP_LEVEL_DIR%\smplayer-build64
set MPV_DIR=%TOP_LEVEL_DIR%\mpv
set OUTPUT_DIR=%TOP_LEVEL_DIR%\output
set PORTABLE_EXE_DIR=%TOP_LEVEL_DIR%\portable

:reask
set /P USER_CHOICE="Choose an action: "
echo.

if "%USER_CHOICE%" == "3"  goto pkgver
if "%USER_CHOICE%" == "4"  goto pkgver
goto reask

:pkgver
if exist "pkg_version" (
  for /f "tokens=*" %%i in ('type pkg_version') do set ALL_PKG_VER=%%i
  goto parse_version
)

echo Format: VER_MAJOR.VER_MINOR.VER_BUILD[.VER_REVISION]
echo VER_REVISION is optional (set to 0 if blank)
echo.
:pkgver_manual
set /p ALL_PKG_VER="Version: "
echo.

:parse_version
for /f "tokens=1 delims=." %%j in ("%ALL_PKG_VER%")  do set VER_MAJOR=%%j
for /f "tokens=2 delims=." %%k in ("%ALL_PKG_VER%")  do set VER_MINOR=%%k
for /f "tokens=3 delims=." %%l in ("%ALL_PKG_VER%")  do set VER_BUILD=%%l
for /f "tokens=4 delims=." %%m in ("%ALL_PKG_VER%")  do set VER_REVISION=%%m

if [%VER_MAJOR%]==[] (
  echo Major Version # must be specified [#.x.x]
  echo.
  goto pkgver_manual
)

if [%VER_MINOR%]==[] (
  echo Minor Version # must be specified [x.#.x]
  echo.
  goto pkgver_manual
)

if [%VER_BUILD%]==[] (
  echo Build Version # must be specified [x.x.#]
  echo.
  goto pkgver_manual
)

if [%VER_REVISION%]==[] (
  set VER_REV_CMD=
) else (
  set VER_REV_CMD= /DVER_REVISION=%VER_REVISION%
)

if "%USER_CHOICE%" == "3"  goto portable
if "%USER_CHOICE%" == "4"  goto portable64
:: Should not happen
goto end

:portable

set SymbolicTestDir1=SymbolicTestDir1-%RANDOM%
set SymbolicTestDir2=SymbolicTestDir2-%RANDOM%
mkdir %TEMP%\%SymbolicTestDir1% >nul
mklink /D %TEMP%\%SymbolicTestDir2% %TEMP%\%SymbolicTestDir1% >nul

if not exist %TEMP%\%SymbolicTestDir2% (
  echo This script requires elevated privileges to create symbolic links. Run the script elevated ^(Run as administrator^) or enable SeCreateSymbolicLinkPrivilege on your account
  echo in the Local Security Policy Editor.

  rmdir %TEMP%\%SymbolicTestDir1%
)
rmdir %TEMP%\%SymbolicTestDir1%
rmdir %TEMP%\%SymbolicTestDir2%

:: Check for portable exes
echo --- SMPlayer Portable Package [32-bit] ---
echo.

if not exist %PORTABLE_EXE_DIR%\smplayer-portable.exe (
  echo SMPlayer portable EXE not found!
  goto end
)

if not exist %PORTABLE_EXE_DIR%\smtube-portable.exe (
  echo Warning: SMTube portable EXE not found!
)

if not exist %MPV_DIR% (
  echo MPV directory not found!
  goto end
)

ren %SMPLAYER_DIR% smplayer-mpv-portable-%ALL_PKG_VER%
set SMPLAYER_PORTABLE_DIR=%TOP_LEVEL_DIR%\smplayer-mpv-portable-%ALL_PKG_VER%

if not exist %TOP_LEVEL_DIR%\smplayer-mpv-portable-%ALL_PKG_VER% (
  echo Oops! Unable to find renamed directory, make sure no files are opened.
  goto end
)

::
echo Backing up files...

ren %SMPLAYER_PORTABLE_DIR%\smplayer.exe smplayer.bak
ren %SMPLAYER_PORTABLE_DIR%\smtube.exe smtube.bak
ren %SMPLAYER_PORTABLE_DIR%\mplayer mplayer.bak

::
echo Creating screenshots dir...

mkdir %SMPLAYER_PORTABLE_DIR%\screenshots

::
echo Copying portable .exe...

copy /y %PORTABLE_EXE_DIR%\smplayer-portable.exe %SMPLAYER_PORTABLE_DIR%\smplayer.exe
copy /y %PORTABLE_EXE_DIR%\smtube-portable.exe %SMPLAYER_PORTABLE_DIR%\smtube.exe

::
echo Creating symbolic link to MPV...
rem xcopy %MPV_DIR% %SMPLAYER_PORTABLE_DIR%\mplayer\ /E
rem Requires SeCreateSymbolicLinkPrivilege
rem mklink included by default Vista+, additional download on XP
mklink /D %SMPLAYER_PORTABLE_DIR%\mplayer %MPV_DIR%

::
echo Finalizing package...
7za a -t7z %OUTPUT_DIR%\smplayer-mpv-portable-%ALL_PKG_VER%.7z %SMPLAYER_PORTABLE_DIR% -xr!*.bak* -xr!open-fonts -xr!docs -xr!imageformats -xr!shortcuts -xr!Finding_subtitles.txt -xr!Not_so_obvious_things.txt -xr!Watching_TV.txt -xr!sample.avi -xr!Notes_about_mpv.txt -xr!dvdmenus.txt -xr!mpv64.exe -xr!mpv64.com -mx9 >nul

echo.
echo Restoring source folder(s) back to its original state...
echo.
rem DO NOT use 'rmdir /q /s' to delete directory symbolic links
rmdir %SMPLAYER_PORTABLE_DIR%\mplayer
rmdir %SMPLAYER_PORTABLE_DIR%\screenshots
REM rmdir %SMPLAYER_PORTABLE_DIR%\screenshots
REM del %SMPLAYER_PORTABLE_DIR%\smplayer.ini
REM del %SMPLAYER_PORTABLE_DIR%\smplayer_orig.ini
del %SMPLAYER_PORTABLE_DIR%\smplayer.exe
del %SMPLAYER_PORTABLE_DIR%\smtube.exe
ren %SMPLAYER_PORTABLE_DIR%\smplayer.bak smplayer.exe
ren %SMPLAYER_PORTABLE_DIR%\smtube.bak smtube.exe
ren %SMPLAYER_PORTABLE_DIR%\mplayer.bak mplayer
ren %SMPLAYER_PORTABLE_DIR% smplayer-build

goto end

:portable64
echo --- SMPlayer Portable Package [64-bit] ---
echo.

:: Check for portable exes
if not exist %PORTABLE_EXE_DIR%\smplayer-portable64.exe (
  echo SMPlayer portable EXE not found!
  goto end
)

if not exist %PORTABLE_EXE_DIR%\smtube-portable64.exe (
  echo Warning: SMTube portable EXE not found!
)

if not exist %MPV_DIR% (
  echo MPV directory not found!
  goto end
)

for %%F in (%MPV_DIR%\mpv64.exe %MPV_DIR%\mpv64.com) do if not exist %%F (
  echo 64-bit MPV executables not found!
  goto end
)

ren %SMPLAYER_DIR64% smplayer-mpv-portable-%ALL_PKG_VER%-x64
set SMPLAYER_PORTABLE_DIR=%TOP_LEVEL_DIR%\smplayer-mpv-portable-%ALL_PKG_VER%-x64

if not exist %TOP_LEVEL_DIR%\smplayer-mpv-portable-%ALL_PKG_VER%-x64 (
  echo Oops! Unable to find renamed directory, make sure no files are opened.
  goto end
)

::
echo Backing up files...

ren %SMPLAYER_PORTABLE_DIR%\smplayer.exe smplayer.bak
ren %SMPLAYER_PORTABLE_DIR%\smtube.exe smtube.bak
ren %SMPLAYER_PORTABLE_DIR%\mplayer mplayer.bak

::
echo Creating screenshots dir...

mkdir %SMPLAYER_PORTABLE_DIR%\screenshots

::
echo Copying portable .exe...

copy /y %PORTABLE_EXE_DIR%\smplayer-portable64.exe %SMPLAYER_PORTABLE_DIR%\smplayer.exe
copy /y %PORTABLE_EXE_DIR%\smtube-portable64.exe %SMPLAYER_PORTABLE_DIR%\smtube.exe

::
echo Creating symbolic link to MPV...
rem xcopy %MPV_DIR% %SMPLAYER_PORTABLE_DIR%\mplayer\ /E
rem Requires SeCreateSymbolicLinkPrivilege
rem mklink included by default Vista+, additional download on XP
mklink /D %SMPLAYER_PORTABLE_DIR%\mplayer %MPV_DIR%
ren %SMPLAYER_PORTABLE_DIR%\mplayer\mpv.exe mpv.exe.bak32
ren %SMPLAYER_PORTABLE_DIR%\mplayer\mpv.com mpv.com.bak32
ren %SMPLAYER_PORTABLE_DIR%\mplayer\mpv64.exe mpv.exe
ren %SMPLAYER_PORTABLE_DIR%\mplayer\mpv64.com mpv.com

::
echo Finalizing package...
7za a -t7z %OUTPUT_DIR%\smplayer-mpv-portable-%ALL_PKG_VER%-x64.7z %SMPLAYER_PORTABLE_DIR% -xr!*.bak* -xr!open-fonts -xr!docs -xr!imageformats -xr!shortcuts -xr!Finding_subtitles.txt -xr!Not_so_obvious_things.txt -xr!Watching_TV.txt -xr!sample.avi -xr!Notes_about_mpv.txt -xr!dvdmenus.txt -mx9 >nul

echo.
echo Restoring source folder(s) back to its original state...
echo.
REM rmdir %SMPLAYER_PORTABLE_DIR%\screenshots
REM del %SMPLAYER_PORTABLE_DIR%\smplayer.ini
REM del %SMPLAYER_PORTABLE_DIR%\smplayer_orig.ini
del %SMPLAYER_PORTABLE_DIR%\smplayer.exe
del %SMPLAYER_PORTABLE_DIR%\smtube.exe
ren %SMPLAYER_PORTABLE_DIR%\mplayer\mpv.exe mpv64.exe
ren %SMPLAYER_PORTABLE_DIR%\mplayer\mpv.com mpv64.com
ren %SMPLAYER_PORTABLE_DIR%\mplayer\mpv.exe.bak32 mpv.exe
ren %SMPLAYER_PORTABLE_DIR%\mplayer\mpv.com.bak32 mpv.com
rem DO NOT use 'rmdir /q /s' to delete directory symbolic links
rmdir %SMPLAYER_PORTABLE_DIR%\mplayer
rmdir %SMPLAYER_PORTABLE_DIR%\screenshots
ren %SMPLAYER_PORTABLE_DIR%\smplayer.bak smplayer.exe
ren %SMPLAYER_PORTABLE_DIR%\smtube.bak smtube.exe
ren %SMPLAYER_PORTABLE_DIR%\mplayer.bak mplayer
ren %SMPLAYER_PORTABLE_DIR% smplayer-build64

goto end

:end

pause
