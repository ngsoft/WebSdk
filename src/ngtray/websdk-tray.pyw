import pystray
import sys
import os
import json
import winreg
import win32api
import time  # type: ignore
import subprocess  # type: ignore
import sys
from iconloader import IconLoader

appName = "Tray"
exeName = "tray"
pth = "."


try:
    pth = os.path.dirname(os.path.abspath(sys.argv[0]))
    os.chdir(pth)
    exeName = os.path.splitext(os.path.basename(os.path.abspath(sys.argv[0])))[0]

    for d in ["./", "../etc/"]:
        if os.path.exists(d + exeName + ".json"):
            pth = os.path.abspath(d)
            break
except:
    pass


configFile = os.path.join(pth, exeName + ".json")
darkMode = False
canRun = True
loopCount = 0
loopInterval = 4
waitBetweenProcesses = 0.5


# noinspection PyUnresolvedReferences
def alert(msg, title=appName):
    win32api.MessageBox(0, msg, title)


def check_darkmode(useSystem=True):
    registry = winreg.ConnectRegistry(None, winreg.HKEY_CURRENT_USER)
    reg_keypath = r"SOFTWARE\Microsoft\Windows\CurrentVersion\Themes\Personalize"
    try:
        reg_key = winreg.OpenKey(registry, reg_keypath)
    except FileNotFoundError:
        return False

    for j in range(1024):
        try:
            value_name, value, _ = winreg.EnumValue(reg_key, j)
            if not useSystem:
                if value_name == "AppsUseLightTheme":
                    return value == 0
            else:
                if value_name == "SystemUsesLightTheme":
                    return value == 0
        except OSError:
            break
    return False


def load_config(file=configFile):
    try:
        with open(file, encoding="utf-8") as h:
            return json.load(h)
    except:
        return None


# noinspection PyTypeChecker
def save_config(cfg, file=configFile):
    try:
        with open(file, "w", encoding="utf-8") as h:
            json.dump(cfg, h, indent=4, ensure_ascii=False)
            return True
    except:
        return False


def run_command(cmd, waitBefore=0.0):

    try:
        if waitBefore > 0:
            time.sleep(waitBefore)

        if not isinstance(cmd, list):
            cmd = cmd.split()
        subprocess.Popen(
            cmd,
            stdout=subprocess.DEVNULL,
            stderr=subprocess.DEVNULL,
            creationflags=0x08000000,
        )
        # subprocess.run(cmd, creationflags=0x08000000)
    except:
        pass


def run_process_list(processList):
    try:
        for cmd in processList:
            run_command(cmd, waitBetweenProcesses)
    except:
        pass


def process_exists(process_name):
    revert = False
    if process_name[0] == "!":
        revert = True
        process_name = process_name[1:]
    call = "TASKLIST", "/FI", "imagename eq %s" % process_name.lower()
    # use buildin check_output right away
    output = subprocess.check_output(call, creationflags=0x08000000).decode(
        "windows-1252"
    )
    # check in last line for process name
    last_line = output.strip().split("\r\n")[-1]
    # because Fail message could be translated
    result = last_line.lower().startswith(process_name.lower())
    if revert:
        return not result
    return result


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


def notify(msg):
    try:
        tray.notify(msg, appName)
    except:
        pass


def get_icon(dark=None):
    if dark is None:
        dark = check_darkmode()
    if activeMode in icons["dark"] and dark:
        return icons["dark"][activeMode]
    if activeMode in icons["light"]:
        return icons["light"][activeMode]

    for fallback in icons["light"].keys():
        if fallback in icons["dark"] and dark:
            return icons["dark"][fallback]
        return icons["light"][fallback]


def action_run(app):
    global prevMode, activeMode, states, darkMode

    update = False
    if check_darkmode() != darkMode:
        darkMode = not darkMode
        update = True

    # check modes
    mode = None
    for name in states:
        result = True
        cnt = 0
        if name in processChecks:
            cnt = len(processChecks[name])
            result = check_process_list(processChecks[name])
        if name in filesChecks:
            for file in filesChecks[name]:
                cnt += 1
                if not os.path.exists(file):
                    result = False
                    break

        if mode is None and result and name in icons["light"]:
            mode = name

        if cnt == 0 and mode != name:
            result = False
        if result is not states[name]:
            update = True
        states[name] = result

    if mode is not None:
        activeMode = mode
    if prevMode != activeMode:
        prevMode = activeMode
        update = True

    if update:
        app.icon = get_icon(darkMode)
        app.update_menu()


def action_setup(app):
    global canRun, loopCount, canAutoStart, autostart
    app.visible = True
    loopCount = 0
    while canRun:
        if not loopCount or loopCount % loopInterval == 0:
            loopCount = 0
            action_run(app)
            if canAutoStart and autostart and not get_state(starter):
                canAutoStart = False
                run_item(starter)
        loopCount += 1
        time.sleep(1)


def action_autostart(_, item):
    global autostart, config, canAutoStart
    value = not item.checked
    autostart = config["autostart"] = value
    save_config(config)
    canAutoStart = autostart


# noinspection PyUnresolvedReferences,PyProtectedMember
def action_quit():
    global canRun
    canRun = False
    try:
        tray.stop()
    except:
        try:
            sys.exit(0)
        except SystemExit as err:
            os._exit(err.code)


def action_click(app, item):
    if run_item(get_name(item)):
        action_run(app)


def run_item(name):
    action = "start"
    launch = list()
    if len(starters[name]) > 0:
        launch = list(starters[name])
    if len(stoppers[name]) > 0 and get_state(name):
        launch = list(stoppers[name])
        action = "stop"
    if not len(launch):
        return False

    if name in notifications[action]:
        notify(notifications[action][name])
    run_process_list(launch)
    return True


def action_checked(item):
    return get_state(get_name(item))


def action_visible(item):
    name = get_name(item)
    if isinstance(visibility[name], bool):
        return visibility[name]
    for mode in visibility[name]:
        if mode[0] == "!":
            mode = mode[1:]
            if mode in states and states[mode]:
                return False
            continue
        if not mode in states or not states[mode]:
            return False
    return True


def get_name(item):
    i = 0
    while i < len(items):
        if items[i] is item:
            return names[i]
        i += 1
    return None


def get_state(name):
    if not name in states:
        return False
    return states[name]


# Config data
items = list()  # this is the pystray items
icons = {
    "light": {},
    "dark": {},
}  # icons to be loaded from modes
names = list()  # list all the labels
processChecks = dict()  # this is all the process checks for modes
filesChecks = dict()  # this is all the file checks for modes
starters = dict()  # this is all the processes to launch on start
stoppers = dict()  # this is all the processes to launch on stop
visibility = dict()  # this is all the conditions to be visible
states = dict()  # this is the checkboxes states
notifications = {
    "start": {},
    "stop": {},
}  # this is the notifications
labels = {
    "Exit": "Exit",
    "Auto Start": "Auto Start",
    "No Config %s": "Cannot load config file %s",
    "No Icons": "No icons have been defined",
    "Cannot find icon %s": "Cannot find icon %s",
}  # this is the translated labels


# first matching checked mode in menu list
starter = None  # first matching starter
autostart = False
canAutoStart = False
prevMode = activeMode = None
activeModes = list()  # reference all the modes that can be activated (with icons)


if __name__ == "__main__":
    # load config
    config = load_config(configFile)
    if config is None or not "menu" in config:
        alert(labels["No Config %s"] % os.path.basename(configFile))
        action_quit()

    # read configuration
    try:
        if "label" in config:
            appName = config["label"]
        if "autostart" in config:
            autostart = config["autostart"] == True
        if "waitBetweenProcesses" in config and config["waitBetweenProcesses"] > 0:
            waitBetweenProcesses = float(config["waitBetweenProcesses"])

        if "labels" in config:
            if isinstance(config["labels"], dict):
                for k, v in config["labels"].items():
                    labels[k] = v
        sep = 0
        for menuItem in config["menu"]:
            if menuItem == "separator":
                name = "sep%d" % sep
                names.append(name)
                items.append(pystray.Menu.SEPARATOR)
                sep += 1
                continue
            elif isinstance(menuItem, dict):
                name = menuItem["name"]
                label = menuItem["label"]
                names.append(name)
                keys = ["light", "dark"]
                if "icons" in menuItem:
                    i = 0
                    while i < len(menuItem["icons"]):
                        if i == 2:
                            break
                        k = keys[i]
                        fileName = menuItem["icons"][i]
                        f = IconLoader.get_icon(fileName)
                        if f is not None:
                            icons[k][name] = f
                            if i == 0:
                                activeModes.append(name)
                                # set active mode to be the last icon in the list
                                activeMode = prevMode = name
                        else:
                            alert(labels["Cannot find icon %s"] % fileName)
                            action_quit()
                        i += 1

                if "start" in menuItem:
                    if isinstance(menuItem["start"], list):
                        starters[name] = list(menuItem["start"])
                if name not in starters:
                    starters[name] = []
                if starter is None and name in activeModes and len(starters[name]) > 0:
                    starter = name
                if "stop" in menuItem:
                    if isinstance(menuItem["stop"], list):
                        stoppers[name] = list(menuItem["stop"])
                if name not in stoppers:
                    stoppers[name] = []

                if "visible" in menuItem:
                    if isinstance(menuItem["visible"], bool):
                        visibility[name] = menuItem["visible"] == True
                    if isinstance(menuItem["visible"], str):
                        menuItem["visible"] = [menuItem["visible"]]
                    if isinstance(menuItem["visible"], list):
                        if len(menuItem["visible"]) > 0:
                            visibility[name] = list(menuItem["visible"])
                        else:
                            visibility[name] = True
                else:
                    visibility[name] = True

                if "notify" in menuItem:
                    if (
                        isinstance(menuItem["notify"], list)
                        and len(menuItem["notify"]) > 0
                    ):
                        notifications["start"][name] = menuItem["notify"][0]
                        if len(menuItem["notify"]) > 1:
                            notifications["stop"][name] = menuItem["notify"][1]

                canCheckbox = False
                if "checks" in menuItem:
                    checks = menuItem["checks"]
                    if "process" in checks:
                        if isinstance(checks["process"], str):
                            checks["process"] = [checks["process"]]
                        if (
                            isinstance(checks["process"], list)
                            and len(checks["process"]) > 0
                        ):
                            processChecks[name] = list(checks["process"])
                            canCheckbox = True
                    if "files" in checks:
                        if isinstance(checks["files"], str):
                            checks["files"] = [checks["files"]]
                        if (
                            isinstance(checks["files"], list)
                            and len(checks["files"]) > 0
                        ):
                            filesChecks[name] = list(checks["files"])
                            canCheckbox = len(filesChecks[name]) > 0

                if canCheckbox or name in activeModes:
                    states[name] = activeMode == name

                items.append(
                    pystray.MenuItem(
                        text=label,
                        action=action_click,
                        checked=action_checked,
                        visible=action_visible,
                    )
                )

        if activeMode is None:
            alert(labels["No Icons"])
            action_quit()
        if starter is not None:
            canAutoStart = True
    except BaseException as e:
        alert("Cannot load config: " + repr(e))
        action_quit()

    if canAutoStart:
        items.append(pystray.Menu.SEPARATOR)
        items.append(
            pystray.MenuItem(
                labels["Auto Start"],
                action_autostart,
                checked=lambda item: autostart,
            )
        )
    items.append(pystray.Menu.SEPARATOR)
    items.append(pystray.MenuItem(labels["Exit"], action_quit))

    tray = pystray.Icon(
        appName,
        icon=get_icon(darkMode),
        title=appName,
        menu=items,
    )

    tray.run(action_setup)
