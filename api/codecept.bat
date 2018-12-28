@echo off
@setlocal
@chcp 65001
set CODECEPT_PATH=../vendor/bin/
"%CODECEPT_PATH%codecept.bat" %*
@endlocal