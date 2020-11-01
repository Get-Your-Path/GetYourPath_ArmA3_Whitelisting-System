<p align="center"><img src="https://img.shields.io/badge/VERSION-1.0.0-yellowgreen?style=for-the-badge" /></p>

# Whitelisting System for ArmA 3

This repository contains **all the files required** for setting up a whitelisting system using XenForo 2.1 for ArmA 3.

It's recommended to have an official version of XenForo available for purchase [HERE](https://xenforo.com/).

## Features
- Automatic whitelist of all members of a group.
- Several conditions in order to whitelist only members who have as main group "Member" and as sub-group "Citizen" on XenForo.
- Logs

## Configuration
### XenForo 2.1 (Step 1)
- Configure the [whitelist.php](https://github.com/JasonA3/Whitelisting-System/blob/main/English%20version/whitelist.php) with your database information (Line 23,24,25,26 and 34,35,36,37)
- Configure the [whitelist.php](https://github.com/JasonA3/Whitelisting-System/blob/main/English%20version/whitelist.php) with your XenForo 2.1 group information (line 62). You can add as many groups / secondary groups as you want. Respect the syntax already present.
- Upload the [whitelist.php](https://github.com/JasonA3/Whitelisting-System/blob/main/English%20version/whitelist.php) on your Website.
- Create a CRON job that will automatically run https://yourserver.com/whitelist.php every 15 minutes (recommended).

### Database (Step 2)
- Execute the script [database](https://github.com/JasonA3/Whitelisting-System/blob/main/English%20version/database.sql) in the database of your **Gameserver**.
```
uid = Player SteamID64
beguid = Player BattlEye UID
forumid = XenForo 2.1 player id
```

### Batch (Step 3)
- Put the [Software folder](https://github.com/JasonA3/Whitelisting-System/tree/main/English%20version/Software) on your Dedicated Server.
- Configure [StartWhitelist.bat](https://github.com/JasonA3/Whitelisting-System/blob/main/English%20version/Software/StartWhitelist.bat) with your RCON information.
- Start [StartWhitelist.bat](https://github.com/JasonA3/Whitelisting-System/blob/main/English%20version/Software/StartWhitelist.bat) after each start of your server.

## Q&A
### How to find the forumid manually ?
[screenshot](https://i.imgur.com/xohc1pb.png)

### How to create a CRON job ?
Check with your web host.

### It's possible to improve this system?
Contact me if you want to improve the system. [Discord](https://discord.gg/GDz8zNZpCJ)

### Does this system work with XenForo 1.0, 2.0 and 2.2 ?
This system was created for XenForo 2.1. It is not functional on XenForo 1.0 and I have not tried on version 2.0 and 2.2. I imagine this should work but no support will be provided for these versions

### How to find the group id on XenForo ?
[screenshot](https://i.imgur.com/Vv7vI5E.png)

## Bugs report
Please open an issue for any encountered bug, I'll do my best to correct it.

If you are not familiar with the GitHub's issue system, please refer to [the documentation](https://guides.github.com/features/issues/)

You can join my Discord if you want to suggest somethings or report an issue ! [Discord](https://discord.gg/GDz8zNZpCJ)
