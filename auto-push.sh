git add .

echo -n "[+] Insert commit message: "
read msg
git commit -m"${msg}"
git push -u origin master