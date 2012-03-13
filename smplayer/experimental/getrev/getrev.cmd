@echo off

:: Undefine for mulitple runs. For some reason you have to use 'if not defined REVISION'
:: otherwise it overwrites the variable with a weird result.
set REVISION=

for /F "tokens=2 skip=4" %%G in ('svn info --revision HEAD') do ^
if not defined REVISION set REVISION=%%G

:: Set to 0 if unknown (no svn or working copy)
if "%REVISION%"=="" (
  set REVISION=0
)

if "%REVISION%"=="0" (
echo Unknown SVN revision. SVN missing in PATH or not a working copy.
) else (
echo Compiling SVN Revision: %REVISION%
)
echo.

:: Use "Fake SED"
call fsed.cmd $WCREV$ %REVISION% svn_revision.h.in>..\src\svn_revision.h

:: Use GNU SED Win32
:: sed s:\$WCREV\$:%REVISION%: svn_revision.h.in>..\src\svn_revision.h