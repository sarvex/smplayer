; Script generated by the Inno Setup Script Wizard.
; SEE THE DOCUMENTATION FOR DETAILS ON CREATING INNO SETUP SCRIPT FILES!

[Setup]
AppName=SMPlayer
AppVerName=SMPlayer 0.6.6
AppPublisher=RVM
AppPublisherURL=http://smplayer.sf.net
AppSupportURL=http://smplayer.sourceforge.net/forums
AppUpdatesURL=http://smplayer.sourceforge.net/
DefaultDirName={pf}\SMPlayer
DefaultGroupName=SMPlayer
LicenseFile=Copying.txt
OutputDir=..
OutputBaseFilename=smplayer_0.6.6_setup
Compression=lzma
SolidCompression=yes
SourceDir="smplayer-build"

[Languages]
Name: "english"; MessagesFile: "compiler:Default.isl"
Name: "basque"; MessagesFile: "compiler:Languages\Basque.isl"
Name: "brazilianportuguese"; MessagesFile: "compiler:Languages\BrazilianPortuguese.isl"
Name: "catalan"; MessagesFile: "compiler:Languages\Catalan.isl"
Name: "czech"; MessagesFile: "compiler:Languages\Czech.isl"
Name: "danish"; MessagesFile: "compiler:Languages\Danish.isl"
Name: "dutch"; MessagesFile: "compiler:Languages\Dutch.isl"
Name: "finnish"; MessagesFile: "compiler:Languages\Finnish.isl"
Name: "french"; MessagesFile: "compiler:Languages\French.isl"
Name: "german"; MessagesFile: "compiler:Languages\German.isl"
Name: "hebrew"; MessagesFile: "compiler:Languages\Hebrew.isl"
Name: "hungarian"; MessagesFile: "compiler:Languages\Hungarian.isl"
Name: "italian"; MessagesFile: "compiler:Languages\Italian.isl"
Name: "norwegian"; MessagesFile: "compiler:Languages\Norwegian.isl"
Name: "polish"; MessagesFile: "compiler:Languages\Polish.isl"
Name: "portuguese"; MessagesFile: "compiler:Languages\Portuguese.isl"
Name: "russian"; MessagesFile: "compiler:Languages\Russian.isl"
Name: "slovak"; MessagesFile: "compiler:Languages\Slovak.isl"
Name: "slovenian"; MessagesFile: "compiler:Languages\Slovenian.isl"
Name: "spanish"; MessagesFile: "compiler:Languages\Spanish.isl"

[Tasks]
Name: "desktopicon"; Description: "{cm:CreateDesktopIcon}"; GroupDescription: "{cm:AdditionalIcons}";

[Types]
Name: "full"; Description: "Full installation"
Name: "custom"; Description: "Custom installation"; Flags: iscustom

[Components]
Name: "main"; Description: "Main Files"; Flags: fixed; Types: full custom
Name: "themes"; Description: "Icon Themes"; Types: full custom
;Name: "codecs"; Description: "Optional codecs"; Types: full custom
Name: "languages"; Description: "Translations"; Types: full custom

[Files]
;Source: "mplayer\codecs\*"; DestDir: "{app}\mplayer\codecs"; Flags: ignoreversion recursesubdirs createallsubdirs; Components: codecs
Source: "mplayer\*"; DestDir: "{app}\mplayer"; Flags: ignoreversion; Components: main
Source: "mplayer\mplayer\*"; DestDir: "{app}\mplayer\mplayer"; Flags: ignoreversion recursesubdirs createallsubdirs; Components: main
Source: "shortcuts\*"; DestDir: "{app}\shortcuts"; Flags: ignoreversion recursesubdirs createallsubdirs; Components: main
Source: "docs\*"; DestDir: "{app}\docs"; Flags: ignoreversion recursesubdirs createallsubdirs; Components: main
Source: "themes\*"; DestDir: "{app}\themes"; Flags: ignoreversion recursesubdirs createallsubdirs; Components: themes
Source: "translations\*"; DestDir: "{app}\translations"; Flags: ignoreversion recursesubdirs createallsubdirs; Components: languages
Source: "*.dll"; DestDir: "{app}"; Components: main
Source: "*.txt"; DestDir: "{app}"; Components: main
Source: "Release_notes.txt"; DestDir: "{app}"; Flags: isreadme; Components: main
Source: "smplayer.exe"; DestDir: "{app}"; Components: main
Source: "dxlist.exe"; DestDir: "{app}"; Components: main
; NOTE: Don't use "Flags: ignoreversion" on any shared system files

[Icons]
Name: "{group}\SMPlayer"; Filename: "{app}\smplayer.exe"
Name: "{group}\{cm:ProgramOnTheWeb,SMPlayer}"; Filename: "http://smplayer.sf.net"
Name: "{group}\{cm:UninstallProgram,SMPlayer}"; Filename: "{uninstallexe}"
Name: "{commondesktop}\SMPlayer"; Filename: "{app}\smplayer.exe"; Tasks: desktopicon

[Registry]

;HKEY_CLASSES_ROOT ProgId registration
Root: HKCR; SubKey: MPlayerFileVideo; Flags: uninsdeletekey
Root: HKCR; SubKey: MPlayerFileVideo\DefaultIcon; ValueType: string; ValueName: ; ValueData: """{app}\smplayer.exe"",1"
Root: HKCR; SubKey: MPlayerFileVideo\shell\enqueue; ValueType: string; ValueName: ; ValueData: Enqueue in SMPlayer
Root: HKCR; SubKey: MPlayerFileVideo\shell\enqueue\command; ValueType: string; ValueName: ; ValueData: """{app}\smplayer.exe"" -add-to-playlist ""%1"""
Root: HKCR; SubKey: MPlayerFileVideo\shell\open; ValueType: string; ValueName: FriendlyAppName; ValueData: SMPlayer Media Player
Root: HKCR; SubKey: MPlayerFileVideo\shell\open\command; ValueType: string; ValueName: ; ValueData: """{app}\smplayer.exe"" ""%1"""

;Windows VISTA Default Programs associations
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer; Flags: uninsdeletekeyifempty; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities; Flags: uninsdeletekey; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities; ValueType: string; ValueName: ApplicationDescription; ValueData: SMPlayer intends to be a complete front-end for MPlayer, from basic features like playing videos, DVDs, and VCDs to more advanced features like support for MPlayer filters and more.; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities; ValueType: string; ValueName: ApplicationName; ValueData: SMPlayer; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .3gp; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .ac3; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .ape; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .asf; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .avi; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .bin; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .dat; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .divx; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .dv; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .dvr-ms; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .flv; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .iso; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .m1v; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .m2v; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .m4v; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .mkv; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .mov; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .mp3; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .mp4; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .mpeg; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .mpg; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .mpv; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .mqv; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .nsv; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .ogg; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .ogm; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .ra; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .ram; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .rmvb; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .ts; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .vcd; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .vfw; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .vob; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .wav; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .wma; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\Clients\Media\SMPlayer\Capabilities\FileAssociations; ValueType: string; ValueName: .wmv; ValueData: MPlayerFileVideo; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\RegisteredApplications; Flags: dontcreatekey; MinVersion: 0,6.0.6000
Root: HKLM; SubKey: SOFTWARE\RegisteredApplications; ValueType: string; ValueName: SMPlayer; ValueData: SOFTWARE\Clients\Media\SMPlayer\Capabilities; Flags: uninsdeletevalue; MinVersion: 0,6.0.6000

[Run]
Filename: "{app}\smplayer.exe"; Parameters: "http://88.191.30.130:8050"; Description: "{cm:LaunchProgram,SMPlayer}"; Flags: nowait postinstall skipifsilent

[UninstallRun]
;Restore all file associations...
Filename: "{app}\smplayer.exe"; Parameters: "-uninstall"

