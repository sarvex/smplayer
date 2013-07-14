@echo off

set config_file=setup\scripts\win32inst_vars.cmd

set gcc_target=
set smplayer_svn_dir=
set smtube_svn_dir=
set themes_svn_dir=
set skins_svn_dir=
set mingw_dir=
set is64bit=

set qtdir=
set qtver=
set trunk_dir=
set svn_trunkdir=
set svn_topdir=

for /f "usebackq tokens=2" %%i in (`"gcc -v 2>&1 | find "Target""`) do set gcc_target=%%i
if [%gcc_target%]==[x86_64-w64-mingw32] (

  set is64bit=yes

) else if [%gcc_target%]==[i686-w64-mingw32] (

  set is64bit=no

) else if [%gcc_target%]==[mingw32] (

  set is64bit=no

)

:: MinGW dir from gcc
for /f "usebackq tokens=1 delims=.." %%i in (`"gcc -print-search-dirs 2>&1 | find "install""`) do set mingw_dir=%%i
for /f "tokens=2 delims= " %%i in ("%mingw_dir%") do set mingw_dir=%%i
if %mingw_dir:~-1%==\ set mingw_dir=%mingw_dir:~0,-1%

:: Qt/SVN locations from qmake
for /f "tokens=*" %%b in ('qmake -query QT_INSTALL_PREFIX') do set qtdir=%%b
for /f "tokens=*" %%c in ('qmake -query QT_VERSION') do set qtver=%%c

set smplayer_svn_dir=%~dp0
:: Does string have a trailing slash? if so remove it 
if %smplayer_svn_dir:~-1%==\ set smplayer_svn_dir=%smplayer_svn_dir:~0,-1%

:: Using the \trunk (whole repo checked out as a whole or checked out separately)? 
for %%a in ("%cd%") do set trunk_dir=%%~nxa

if [%trunk_dir%]==[trunk] (

  set svn_topdir=..\..
  set svn_trunkdir=\trunk

) else (

  set svn_topdir=..
  set svn_trunkdir=

)

for /f %%i in ("%svn_topdir%\smtube%svn_trunkdir%") do set smtube_svn_dir=%%~fi
for /f %%i in ("%svn_topdir%\smplayer-themes%svn_trunkdir%") do set themes_svn_dir=%%~fi
for /f %%i in ("%svn_topdir%\smplayer-skins%svn_trunkdir%") do set skins_svn_dir=%%~fi

echo set SMPLAYER_DIR=%smplayer_svn_dir%>%config_file%
echo set SMTUBE_DIR=%smtube_svn_dir%>>%config_file%
echo set SMPLAYER_THEMES_DIR=%themes_svn_dir%>>%config_file%
echo set SMPLAYER_SKINS_DIR=%skins_svn_dir%>>%config_file%
echo set QT_DIR=%qtdir%>>%config_file%
echo set QT_VER=%qtver%>>%config_file%
echo set MINGW_DIR=%MINGW_DIR%>>%config_file%
echo set X86_64=%is64bit%>>%config_file%

:end
