@rem NSIS Uninstall Header Recursive File List Maker
@rem Copyright 2014 Aleksandr Ivankiv

@SET DIR=%~1
@SET HEADER=%~2
@IF "%~1" == "/?" goto Help
@IF NOT DEFINED DIR goto Help
@IF NOT DEFINED HEADER SET HEADER=UnFiles.nsh
@IF NOT EXIST "%DIR%" ECHO Cannot find the folder %DIR%. & SET "DIR=" & goto :EOF

@IF EXIST UnFiles.nsh ( DEL UnFiles.nsh )

@SetLocal EnableDelayedExpansion

@FOR /F "tokens=*" %%f IN ('DIR %DIR%\*.* /A:-D /B /S') DO @(
  set string=%%f
  set string=!string:%CD%\%DIR%=!
  echo Delete "$INSTDIR\!string:~1!" >> %HEADER%
  echo !string:~1!
)

@FOR /F "tokens=*" %%d IN ('DIR %DIR%\*.* /A:D /B /S') DO @(
  set string=%%d
  set string=!string:%CD%\%DIR%=!
  echo RMDir "$INSTDIR\!string:~1!" >> %HEADER%
  echo !string:~1!
)

@EndLocal
@goto :EOF

:Help
@echo.
@echo Usage: UNFILES FolderName [OutFile]
@echo.
@goto :EOF