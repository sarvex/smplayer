; CPUInfo.nsh by f0rt (http://forums.winamp.com/member.php?u=295506)
; Modified by redxii (redxii@users.sourceforge.net)
; Detects number of processor cores and logical processors

!define CPUINFO_FALSE             0 
!define CPUINFO_TRUE              1
!define ERROR_INSUFFICIENT_BUFFER 122
!define RELATIONSHIP_OFFSET       4 ; Offset of Relationship in the SYSTEM_LOGICAL_PROCESSOR_INFORMATION structure
!define RELATIONPROCESSORCORE     0 ; Enum value of Relationship identifying Processor Core
!define SYS_LOG_PROC_INFO_SIZE    24 ; Size of SYSTEM_LOGICAL_PROCESSOR_INFORMATION on 32-bit systems

Var CpuInfo_Cores
Var CpuInfo_Name
Var CpuInfo_Threads

; Count the number of bits set in given value
; Parameters: value
; Returns: number of bits set in given value
Function GetCPUInfo_CountBits

  Exch $0
  Push $1
  Push $2

  ; Set initial value for number of bits set in $0
  StrCpy $1 0

  ${While} $0 > 0
    ; Clear least significant bit set
    IntOp $2 $0 - 1
    IntOp $0 $0 & $2
    ; Increment number of bits set
    IntOp $1 $1 + 1
  ${EndWhile}

  ; Return number of bits set
  StrCpy $0 $1

  Pop $2
  Pop $1
  Exch $0

FunctionEnd

; Evaluate processor information
; Paramaters: buffer, length
; Returns: number of cores
Function GetCPUInfo_Eval

  Exch $0 ; length
  Exch
  Exch $1 ; buffer
  Push $2
  Push $3
  Push $4
  Push $5 ; Processor Cores
  Push $6 ; Logical Processors

  ; Set buffer offset at the end of the buffer
  StrCpy $2 $0

  ; Initialize number of Processor Cores and Logical Processors
  StrCpy $5 0
  StrCpy $6 0

  ; Iterate through buffer starting from end
  ${While} $2 >= ${SYS_LOG_PROC_INFO_SIZE}
    ; Calculate start address of an element
    IntOp $2 $2 - ${SYS_LOG_PROC_INFO_SIZE}
    IntOp $3 $1 + $2
    ; Get ProcessorMask value from element
    System::Call "*$3(i.r4)"
    Push $4
    IntOp $3 $3 + ${RELATIONSHIP_OFFSET}
    ; Get Relationship value from element
    System::Call "*$3(i.r4)"
    ${If} $4 == ${RELATIONPROCESSORCORE}
      ; Increment Processor cores
      IntOp $5 $5 + 1
      ; Determine number of Logical Processor by counting the bits
      ; set in the value of ProcessorMask
      Call GetCPUInfo_CountBits
      Pop $4
      ; Sum up Logical Processors
      IntOp $6 $6 + $4
      ${Else}
        Pop $4
      ${EndIf}
  ${EndWhile}

  ; Set processor information as return value
  StrCpy $CpuInfo_Cores $5
  StrCpy $CpuInfo_Threads $6

  ReadRegStr $CpuInfo_Name HKLM "HARDWARE\DESCRIPTION\System\CentralProcessor\0" "ProcessorNameString"

  StrCpy $0 "$CpuInfo_Name -- $CpuInfo_Cores Core(s), $CpuInfo_Threads Thread(s)"


  Pop $6
  Pop $5
  Pop $4
  Pop $3
  Pop $2
  Pop $1
  Exch $0

FunctionEnd

; Get processor information
; Returns: number of Processor Cores and Logical Processors
Function GetCPUInfo

  Push $0
  Push $1
  Push $2
  Push $3
  Push $4

  ; GetLogicalProcessorInformation is only available on 
  ; Windows XP SP3 or its successors.

  ; Initialize buffer and its length
  StrCpy $1 0
  StrCpy $2 0

  ; Determine required length of buffer
  System::Call "kernel32::GetLogicalProcessorInformation(ir1, *ir2r2) i.r3 ? e"
  Pop $4
  ${If} $3 == ${CPUINFO_FALSE}
    ${If} $4 == ${ERROR_INSUFFICIENT_BUFFER}
      ; Allocate buffer
      System::Alloc $2
      Pop $1
      ${If} $1 != 0
        ; Get processor information
        System::Call "kernel32::GetLogicalProcessorInformation(ir1, *ir2r2) i.r3 ? e"
        Pop $4
        ${If} $3 != ${CPUINFO_TRUE}
          ;StrCpy $0 "Error: $4"
          StrCpy $0 ""
          MessageBox MB_OK|MB_ICONSTOP "Error: $4"
        ${Else}
          Push $1 ; buffer
          Push $2 ; length
          Call GetCPUInfo_Eval
          Pop $0
        ${EndIf}
        ; Deallocate buffer
        System::Free $1
      ${Else}
          ;StrCpy $0 "Error: memory allocation failed!"
          StrCpy $0 ""
          MessageBox MB_OK|MB_ICONSTOP "Error: Memory allocation failed!"
      ${EndIf}
    ${Else}
      ;StrCpy $0 "Error: $4"
      StrCpy $0 ""
      MessageBox MB_OK|MB_ICONSTOP "Error: $4"
    ${EndIf}
  ${Else}
    ;StrCpy $0 "GetLogicalProcessorInformation is not available on your system!"
    StrCpy $0 ""
    MessageBox MB_OK|MB_ICONSTOP "GetLogicalProcessorInformation is not available on your system!"
  ${EndIf}

  Pop $4
  Pop $3
  Pop $2
  Pop $1
  Exch $0

FunctionEnd