@echo off

:: Some SVN clients can use localized messages (e.g. SlikSVN), force English
set LC_ALL=C

:: Undefine for multiple runs in the same command prompt session
set Revision=
for /f "tokens=2" %%i in ('svn info ^| find "Revision: "') do set Revision=%%i

:: Set to UNKNOWN if no svn or working copy
if "%REVISION%"=="" (
  set REVISION=UNKNOWN
)

if "%Revision%"=="UNKNOWN" (
echo Unknown SVN revision. SVN missing in PATH or not a working copy.
) else (
echo SVN Revision: %Revision%
)
echo.

::echo #define SVN_REVISION "SVN-r%REVISION%">src\svn_revision.h

if exist src\svn_revision.h. (del src\svn_revision.h.)

echo /*  smplayer, GUI front-end for mplayer.>>src\svn_revision.h
echo     Copyright (C) 2006-2012 Ricardo Villalba ^<rvm@users.sourceforge.net^>>>src\svn_revision.h
echo.>>src\svn_revision.h
echo     This program is free software; you can redistribute it and/or modify>>src\svn_revision.h
echo     it under the terms of the GNU General Public License as published by>>src\svn_revision.h
echo     the Free Software Foundation; either version 2 of the License, or>>src\svn_revision.h
echo     (at your option) any later version.>>src\svn_revision.h
echo.>>src\svn_revision.h
echo     This program is distributed in the hope that it will be useful,>>src\svn_revision.h
echo     but WITHOUT ANY WARRANTY; without even the implied warranty of>>src\svn_revision.h
echo     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the>>src\svn_revision.h
echo     GNU General Public License for more details.>>src\svn_revision.h
echo.>>src\svn_revision.h
echo     You should have received a copy of the GNU General Public License>>src\svn_revision.h
echo     along with this program; if not, write to the Free Software>>src\svn_revision.h
echo     Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA>>src\svn_revision.h
echo */>>src\svn_revision.h
echo.>>src\svn_revision.h
echo /*  Do not edit src/svn_revision.h, this file will be overwritten when starting>>src\svn_revision.h
echo     the build process. Instead edit getrev/svn_revision.h.in.>>src\svn_revision.h
echo */>>src\svn_revision.h
echo.>>src\svn_revision.h
echo #ifndef _SVN_REVISION_H_>>src\svn_revision.h
echo #define _SVN_REVISION_H_>>src\svn_revision.h
echo.>>src\svn_revision.h
echo #define STR1(x) #x>>src\svn_revision.h
echo #define STR(x) STR1(x)>>src\svn_revision.h
echo.>>src\svn_revision.h
echo #define USE_SVN_VERSIONS ^1>>src\svn_revision.h
echo #define SVN_REVISION %Revision%>>src\svn_revision.h
echo.>>src\svn_revision.h
echo #define VERSION_MAJOR ^0>>src\svn_revision.h
echo #define VERSION_MINOR ^8>>src\svn_revision.h
echo #define VERSION_BUILD ^0>>src\svn_revision.h
echo.>>src\svn_revision.h
echo // SMPlayer>>src\svn_revision.h
echo #if USE_SVN_VERSIONS ^&^& SVN_REVISION ^!= ^0>>src\svn_revision.h
echo #define SMPLAYER_VERSION            STR(VERSION_MAJOR) "." STR(VERSION_MINOR) "." STR(VERSION_BUILD) "+SVN-r" STR(SVN_REVISION)>>src\svn_revision.h
echo #elif USE_SVN_VERSIONS ^&^& SVN_REVISION ^== ^0>>src\svn_revision.h
echo #define SMPLAYER_VERSION            STR(VERSION_MAJOR) "." STR(VERSION_MINOR) "." STR(VERSION_BUILD) "+SVN-rUNKNOWN">>src\svn_revision.h
echo #elif !USE_SVN_VERSIONS>>src\svn_revision.h
echo #define SMPLAYER_VERSION            STR(VERSION_MAJOR) "." STR(VERSION_MINOR) "." STR(VERSION_BUILD)>>src\svn_revision.h
echo #endif>>src\svn_revision.h
echo.>>src\svn_revision.h
echo // Windows Resource File>>src\svn_revision.h
echo #if USE_SVN_VERSIONS>>src\svn_revision.h
echo #define SMPLAYER_FILEVERSION        VERSION_MAJOR, VERSION_MINOR, VERSION_BUILD, SVN_REVISION>>src\svn_revision.h
echo #define SMPLAYER_PRODVERSION        STR(VERSION_MAJOR) "." STR(VERSION_MINOR) "." STR(VERSION_BUILD) "." STR(SVN_REVISION) "\0">>src\svn_revision.h
echo #elif !USE_SVN_VERSIONS>>src\svn_revision.h
echo #define SMPLAYER_FILEVERSION        VERSION_MAJOR, VERSION_MINOR, VERSION_BUILD, ^0>>src\svn_revision.h
echo #define SMPLAYER_PRODVERSION        STR(VERSION_MAJOR) "." STR(VERSION_MINOR) "." STR(VERSION_BUILD) ".0\0">>src\svn_revision.h
echo #endif>>src\svn_revision.h
echo.>>src\svn_revision.h
echo #endif>>src\svn_revision.h
