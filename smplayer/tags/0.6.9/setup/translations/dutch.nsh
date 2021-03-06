﻿;Language: Dutch (1043)
;Dutch language strings for the Windows SMPlayer NSIS installer.
;
;Save file as UTF-8 w/ BOM
;

!insertmacro LANGFILE "Dutch" "Nederlands"

; Startup
${LangFileString} SMPLAYER_INSTALLER_IS_RUNNING "The installer is already running."
${LangFileString} SMPLAYER_INSTALLER_NO_ADMIN "You must be logged in as an administrator when installing this program."

; Components Page
${LangFileString} MPLAYER_CODEC_INFORMATION "The binary codec packages add support for codecs that are not yet implemented natively, like newer RealVideo variants and a lot of uncommon formats.$\nNote that they are not necessary to play most common formats like DVDs, MPEG-1/2/4, etc."

; MPlayer Section
!ifndef WITH_MPLAYER
  ${LangFileString} MPLAYER_IS_DOWNLOADING "Downloading MPlayer..."
  ${LangFileString} MPLAYER_DL_RETRY "MPlayer was not successfully installed. Retry?"
  ${LangFileString} MPLAYER_DL_FAILED "Failed to download MPlayer: '$R0'."
  ${LangFileString} MPLAYER_INST_FAILED "Failed to install MPlayer. MPlayer is required for playback."
!endif

; Codecs Section
${LangFileString} CODECS_IS_DOWNLOADING "Downloading MPlayer codecs..."
${LangFileString} CODECS_DL_RETRY "MPlayer codecs were not successfully installed. Retry?"
${LangFileString} CODECS_DL_FAILED "Failed to download MPlayer codecs: '$R0'."
${LangFileString} CODECS_INST_FAILED "Failed to install MPlayer codecs."

; Version information
${LangFileString} VERINFO_IS_DOWNLOADING "Downloading version information..."
${LangFileString} VERINFO_DL_FAILED "Failed to download version info: '$R0'. Using a default version."

; Uninstaller
${LangFileString} UNINSTALL_NO_ADMIN "This installation can only be uninstalled by a user with administrator privileges."
${LangFileString} UNINSTALL_ABORTED "Uninstall aborted by user."
${LangFileString} SMPLAYER_NOT_INSTALLED "It does not appear that SMPlayer is installed in the directory '$INSTDIR'.$\r$\nContinue anyway (not recommended)?"

; Vista & Later Default Programs Registration
${LangFileString} APPLICATION_DESCRIPTION "SMPlayer is a complete front-end for MPlayer, from basic features like playing videos, DVDs, VCDs to more advanced features like support for MPlayer filters, edl lists, and more."