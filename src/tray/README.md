## websdk-tray

To build:

```shell
pip install pypiwin32 pywin32 pystray pillow --upgrade
pyinstaller --onefile --icon websdk-tray.ico websdk-tray.pyw
copy dist/websdk-tray.exe ../../bin
```
