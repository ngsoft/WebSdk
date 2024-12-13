## ngtray for Windows

#### First install dependencies

```cmd
pip install pypiwin32 pywin32 pystray pillow --upgrade
```

#### Then embed the icons

```cmd
python iconloader.py
```

#### Then build:

```cmd
pyinstaller --onefile --icon app.ico websdk-tray.pyw
@REM pyinstaller --uac-admin --onefile --icon app.ico websdk-tray.pyw
cp websdk-tray.json dist\
```

#### Then install:

```cmd
taskkill /F /IM websdk-tray.exe
copy dist\*.exe ..\..\bin
copy dist\*.json ..\..\etc
```