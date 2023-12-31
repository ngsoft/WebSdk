import pystray
import PIL.Image
import sys
import os
import subprocess
import json
import winreg
import win32api
import time

try:
    os.chdir(os.path.dirname(os.path.abspath(sys.argv[0])))
except:
    pass


CREATE_NO_WINDOW = 0x08000000
on = off = None
mode = None
prev = None
appName = "WebSdk"
exeName = "websdk-tray"
canRun = True
loopCount = 0
loopInterval = 4
configFile = exeName + "/config.json"


def alert(msg, title=appName):
    win32api.MessageBox(0, msg, title)


def load_config(_configFile=configFile):
    try:
        with open(_configFile) as f:
            return json.load(f)
    except:
        return None


def save_config(cfg, _configFile=configFile):
    try:
        with open(_configFile, "w", encoding="utf-8") as f:
            json.dump(cfg, f, indent=4)
            return True
    except:
        return False


def check_config(_config):
    cfgOk = True
    msg = "Error config file: " + configFile
    if _config == None:
        cfgOk = False
    elif not "menu" in _config:
        cfgOk = False
        msg = "No menu in config file"
    elif not "check" in _config:
        cfgOk = False
        msg = "No check in config file"
    elif not "process" in _config["check"]:
        cfgOk = False
        msg = "No process to check in config file"
    elif not "items" in _config["check"]:
        cfgOk = False
        msg = "No items to check in config file"
    elif len(_config["check"]["items"]) < 1:
        cfgOk = False
        msg = "No items to check in config file"
    elif not "autostart" in _config:
        cfgOk = False
        msg = "No autostart in config file"
    elif not "icons" in _config:
        cfgOk = False
        msg = "No icons in config file"
    elif not "dark" in _config["icons"]:
        cfgOk = False
        msg = "No dark icons in config file"

    elif not "light" in _config["icons"]:
        cfgOk = False
        msg = "No light icons in config file"

    if cfgOk == True:
        for key in _config["check"]["items"]:
            for mode in ["light", "dark"]:
                if not key in _config["icons"][mode]:
                    cfgOk = False
                    msg = "No " + key + " " + mode + " icons in config file"
                    break
    if cfgOk == True:
        for _item in _config["menu"]:
            if not "name" in _item:
                cfgOk = False
                msg = "No name set for menu item in config file"
                break
            if not "label" in _item:
                cfgOk = False
                msg = (
                    "No label set for menu item named "
                    + _item["name"]
                    + " in config file"
                )
                break
            if not "exec" in _item:
                cfgOk = False
                msg = (
                    "No process to execute for menu item named "
                    + _item["name"]
                    + " in config file"
                )
                break
            elif len(_item["exec"]) < 1:
                cfgOk = False
                msg = (
                    "No process to execute for menu item named "
                    + _item["name"]
                    + " in config file"
                )
                break

    if not cfgOk:
        alert(msg)
        return False
    return True


def run_command(cmd):
    try:
        subprocess.run(cmd.split(), creationflags=CREATE_NO_WINDOW)
    except:
        pass


def process_exists(process_name):
    call = "TASKLIST", "/FI", "imagename eq %s" % process_name.lower()
    # use buildin check_output right away
    output = subprocess.check_output(call, creationflags=CREATE_NO_WINDOW).decode(
        "windows-1252"
    )
    # check in last line for process name
    last_line = output.strip().split("\r\n")[-1]
    # because Fail message could be translated
    return last_line.lower().startswith(process_name.lower())


def check_process_list(process_list):
    try:
        if len(process_list) == 0:
            return False
        for _proc in process_list:
            if not process_exists(_proc):
                return False
        return True
    except:
        return False


def detect_darkmode(useSystem=True):
    registry = winreg.ConnectRegistry(None, winreg.HKEY_CURRENT_USER)
    reg_keypath = r"SOFTWARE\Microsoft\Windows\CurrentVersion\Themes\Personalize"
    try:
        reg_key = winreg.OpenKey(registry, reg_keypath)
    except FileNotFoundError:
        return False

    for i in range(1024):
        try:
            value_name, value, _ = winreg.EnumValue(reg_key, i)
            if useSystem != True:
                if value_name == "AppsUseLightTheme":
                    return value == 0
            else:
                if value_name == "SystemUsesLightTheme":
                    return value == 0
        except OSError:
            break
    return False


def get_icon(_darkMode=None):
    if _darkMode == None:
        _darkMode = detect_darkmode()
    if _darkMode:
        return icons["dark"][mode]
    else:
        return icons["light"][mode]


def action_autostart(_, item):
    global stateAutostart
    value = not item.checked
    stateAutostart = config["autostart"] = value
    save_config(config)


def detect_mode():
    global mode, on, off
    if off == None:
        for _mode in checksModes:
            off = _mode
            if on == None:
                on = _mode
    mode = off
    if check_process_list(checks):
        mode = on
    return mode


def action_run(icon):
    global prev, on, off, states, darkMode
    _mode = detect_mode()
    if prev != _mode:
        prev = _mode
        darkMode = detect_darkmode()
        icon.icon = get_icon(darkMode)
        states[on] = False
        states[off] = False
        states[_mode] = True
        icon.update_menu()
    elif darkMode != detect_darkmode():
        darkMode = not darkMode
        icon.icon = get_icon(darkMode)
        icon.update_menu()


def action_setup(icon):
    global canRun, loopCount, loopInterval
    icon.visible = True
    run = True
    while canRun:
        if run:
            run = False
            action_run(icon)
        loopCount += 1
        run = loopCount % loopInterval == 0
        time.sleep(1)


def action_checked(item):
    try:
        return mode == modes[item.text]
    except:
        return False


def action_visible(item):
    try:
        return mode in visibility[modes[item.text]]
    except:
        return True


def run_processes(_mode):
    try:
        if _mode == on:
            icon.notify("Starting " + appName, appName)
        elif _mode == off:
            icon.notify("Stopping " + appName, appName)
    except:
        pass
    try:
        for _cmd in processes[_mode]:
            run_command(_cmd)
    except:
        pass


def action_click(icon, item):
    run_processes(modes[item.text])
    action_run(icon)


def action_quit():
    global canRun
    canRun = False
    try:
        icon.stop()
    except:
        try:
            sys.exit(0)
        except SystemExit as e:
            os._exit(e.code)


config = load_config()
if not check_config(config):
    action_quit()

menuItems = dict()
items = list()
processes = dict()
icons = dict()
modes = dict()
visibility = dict()
checks = list(config["check"]["process"])
checksModes = list()
autostart = config["autostart"]
states = dict()
stateAutostart = autostart

for _itemName in config["check"]["items"]:
    checksModes.append(_itemName)
    for systemMode in ["light", "dark"]:
        if not systemMode in icons:
            icons[systemMode] = dict()
        icons[systemMode][_itemName] = PIL.Image.open(
            exeName + "/" + config["icons"][systemMode][_itemName]
        )

for _item in config["menu"]:
    _name = _item["name"]
    _label = _item["label"]
    states[_name] = False
    modes[_label] = _name
    processes[_name] = list(_item["exec"])
    if "visible" in _item:
        if isinstance(_item["visible"], list):
            visibility[_name] = list(_item["visible"])
        elif isinstance(_item["visible"], str):
            visibility[_name] = [_item["visible"]]
        else:
            alert(
                "Invalid visible param for menu item named " + _name + " in config file"
            )
            action_quit()

    items.append(
        pystray.MenuItem(
            text=_label,
            action=action_click,
            checked=action_checked,
            visible=action_visible,
        )
    )

items.append(
    pystray.MenuItem(
        "Auto Start", action_autostart, checked=lambda item: stateAutostart
    )
)
items.append(pystray.MenuItem("Exit", action_quit))
darkMode = detect_darkmode()
detect_mode()
# Autostart
if autostart:
    if mode == off:
        run_processes(on)
        detect_mode()


icon = pystray.Icon(
    appName,
    icon=get_icon(darkMode),
    title=appName,
    menu=items,
)

icon.run(action_setup)
