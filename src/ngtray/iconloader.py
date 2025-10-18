from PIL import Image
import sys
from os import path, mkdir, listdir, utime, _exit as exit
from pathlib import Path
from io import BytesIO  # type: ignore
import base64  # type: ignore
import json
import os


try:
    from build import res
except:
    res = None


def touch(fname, mode=0o666, dir_fd=None, **kwargs):
    flags = os.O_CREAT | os.O_APPEND
    with os.fdopen(os.open(fname, flags=flags, mode=mode, dir_fd=dir_fd)) as f:
        os.utime(
            f.fileno() if os.utime in os.supports_fd else fname,
            dir_fd=None if os.supports_fd else dir_fd,
            **kwargs
        )


class IconLoader(object):
    @staticmethod
    def touch(pth, times=None):
        try:
            with open(pth, "a"):
                utime(pth, times)
        except:
            return False
        return True

    @staticmethod
    def save_file(pth, contents=""):
        try:
            mkdir(path.dirname(pth))
        except:
            pass
        try:
            if isinstance(contents, str):
                contents = contents.encode("utf-8")
            with open(pth, "wb") as f:
                f.write(contents)
                return True
        except:
            return False

    @staticmethod
    def load_file(file) -> bytes:
        try:
            with open(file, "rb") as f:
                contents = f.read()
        except:
            return None
        return contents

    @staticmethod
    def has_icon(pth) -> bool:
        if res is not None:
            return pth in res.icons
        return path.exists(pth)

    @staticmethod
    def get_icon(pth):
        if not IconLoader.has_icon(pth):
            return None
        if res is not None and pth in res.icons:
            pth = BytesIO(base64.b64decode(res.icons[pth]))

        return Image.open(pth)


if __name__ == "__main__":
    resFile = "build/res.py"
    initFile = "build/__init__.py"
    icons = list()
    files = list()
    cfgFiles = [f for f in listdir(".") if path.isfile(f) and f.endswith(".json")]
    for f in cfgFiles:
        cfg = None
        contents = IconLoader.load_file(f)
        try:
            cfg = json.loads(contents)
        except:
            pass

        if isinstance(cfg, dict) and "menu" in cfg:
            menu = cfg["menu"]
            for item in menu:
                if isinstance(item, dict):
                    if "icons" in item and isinstance(item["icons"], list):
                        i = -1
                        while i < len(item["icons"]):
                            if not item["icons"][i] in icons:
                                icons.append(item["icons"][i])
                            i += 1
                            if i == 2:
                                break

        if len(icons) == 0:
            print("no icons to embed\n")
            exit(1)

        text = "icons = {\n"
        values = {}
        for fileName in icons:
            if path.isfile(fileName):
                contents = base64.b64encode(IconLoader.load_file(fileName))
                contents = str(contents)
                text += """    "%s": %s,\n""" % (
                    fileName,
                    contents,
                )
        text += "}\n"

        if IconLoader.save_file(resFile, text):
            touch(initFile)
            print("build complete")
        else:
            print("cannot save file: %s" % resFile)
            exit(1)
