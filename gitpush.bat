@echo off
git add .
echo ===Git Add Done===
set /p hasilCommit=Masukkan Nama Commit: 
git commit -m "%hasilCommit%"
git push -u -f origin master
echo ===Git Push Done===
pause
