call compile_windows2.cmd -makepkg
call clean_windows.cmd
call compile_windows2.cmd -portable -noupdate -makepkg
call clean_windows.cmd