<?php
echo "<p>";
tr("SMPlayer is a graphical interface for %1, which supports many video and audio formats and codecs.",
"MPlayer");

echo "<p>";
tr("Here is a complete list (from the MPlayer documentation):");
echo "<br><br>";
echo "<b>". get_tr("Supported Input Formats") ."</b>";
?>

<ul>
<li>(S)VCD (Super Video CD)</li>
<li>CDRwin's .bin image file</li>
<li>DVD, including encrypted DVD</li>
<li>MPEG-1/2 (ES/PS/PES/VOB)</li>
<li>AVI file format</li>
<li>ASF/WMV/WMA format</li>
<li>QT/MOV/MP4 format</li>
<li>RealAudio/RealVideo format</li>
<li>Ogg/OGM files</li>
<li>Matroska</li>
<li><a href="http://www.nut-container.org">NUT</a></li>
<li>NSV (Nullsoft Streaming Video)</li>
<li>VIVO format</li>
<li>FLI format</li>
<li>NuppelVideo format</li>
<li>yuv4mpeg format</li>
<li>FILM (.cpk) format</li>
<li>RoQ format</li>
<li>PVA format</li>
<li>streaming via HTTP/FTP, RTP/RTSP, MMS/MMST, MPST, SDP</li>
<li>TV grabbing</li>
</ul>

<?php
echo "<b>". get_tr("Supported Video and Audio Codecs") ."</b>";
echo "<br><br>";
echo "<b>". get_tr("most important video codecs:") ."</b>";
?>

<ul>
<li>MPEG-1 (VCD) and MPEG-2 (SVCD/DVD/DVB) video</li>
<li>MPEG-4 ASP in all variants including DivX ;-), OpenDivX (DivX4),
DivX 5 (Pro), Xvid</li>
<li>MPEG-4 AVC aka H.264</li>
<li>Windows Media Video 7/8 (WMV1/2)</li>
<li>Windows Media Video 9 (WMV3) (using x86 DLL)</li>
<li>RealVideo 1.0, 2.0 (G2)</li>
<li>RealVideo 3.0 (RP8), 4.0 (RP9) (using Real libraries)</li>
<li>Sorenson v1/v3 (SVQ1/SVQ3), Cinepak, RPZA and other QuickTime codecs</li>
<li>DV video</li>
<li>3ivx</li>
<li>Intel Indeo3 (3.1, 3.2)</li>
<li>Intel Indeo 4.1 and 5.0 (using x86 DLL or XAnim codecs)</li>
<li>VIVO 1.0, 2.0, I263 and other H.263(+) variants (using x86 DLL)</li>
<li>MJPEG, AVID, VCR2, ASV2 and other hardware formats</li>
<li>FLI/FLC</li>
<li>HuffYUV</li>
<li>various old simple RLE-like formats</li>
</ul>

<?php
echo "<b>". get_tr("most important audio codecs:") ."</b>";
?>

<ul>
<li>MPEG layer 1, 2, and 3 (MP3) audio</li>
<li>AC3/A52, E-AC3, DTS (Dolby Digital) audio (software or SP/DIF)</li>
<li>AAC (MPEG-4 audio)</li>
<li>WMA (DivX Audio) v1, v2</li>
<li>WMA 9 (WMAv3), Voxware audio, ACELP.net etc (using x86 DLLs)</li>
<li>RealAudio: COOK, SIPRO, ATRAC3 (using Real libraries)</li>
<li>RealAudio: DNET and older codecs</li>
<li>QuickTime: Qclp, Q-Design QDMC/QDM2, MACE 3/6 (using QT libraries), ALAC</li>
<li>Ogg Vorbis audio</li>
<li>VIVO audio (g723, Vivo Siren) (using x86 DLL)</li>
<li>alaw/ulaw, (ms)gsm, pcm, *adpcm and other simple old audio formats</li>
</ul>
