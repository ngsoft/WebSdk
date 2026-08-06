@echo off

set CURSOR_BRIDGE_FORCE=true
set CURSOR_BRIDGE_MODE=agent
set CURSOR_BRIDGE_USE_ACP=true
set CURSOR_AGENT_BIN=%LOCALAPPDATA%\cursor-agent\agent.cmd
if exist "%CURSOR_AGENT_BIN%"  (
    if not defined CURSOR_API_KEY (
        call "%CURSOR_AGENT_BIN%" login
    )
    npx cursor-api-proxy --tailscale
)



