<div align="center">

<a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a>  
    
![GitHub top language](https://img.shields.io/github/languages/top/NullBrunk/L3T?style=for-the-badge)
![GitHub commit activity](https://img.shields.io/github/commit-activity/m/NullBrunk/L3T?style=for-the-badge)
![repo size](https://img.shields.io/github/repo-size/NullBrunk/L3T?style=for-the-badge)

![L3T](https://github.com/NullBrunk/L3T/assets/125673909/1c2c492c-1a03-4670-8fb3-1bb291005b2a)

</div>

Created using the **Laravel/Livewire** stack + vanilla JS and CSS, this web app allows multiplayer, real-time tic-tac-toe gameplay. The application is secured with email address validation and the option to use TFA (TOTP). Finally, the project includes internationalization, with French and English currently supported.


# ⚒️ Installation
> [!TIP]
> **There is a Dockerfile as well as a docker-compose file if you want to test this app.**

```bash
git clone https://github.com/NullBrunk/Tic-tac-toe && cd Tic-tac-toe
docker-compose up --build
```

> [!NOTE]
> You may seed the database using:
```bash
docker exec -it morpion-web bash -c 'php artisan db:seed'
```

# 📚 Deep overview

### 🔐 Login


> [!NOTE]
> You can choose whether or not to use 2FA as shown in these videos.

##### Without 2FA
https://github.com/NullBrunk/L3T/assets/125673909/5e55c58b-e841-4126-9835-955c106f4eac



##### With 2FA
https://github.com/NullBrunk/L3T/assets/125673909/333c661b-7209-4f23-bf6a-5b249cba063e





### 🎮 Game

> [!NOTE]
> You can generate a game, and send the unique link to your opponent to challenge them. The board is updated in real-time on both sides, and at the end of the game, the user's statistics are updated.

https://github.com/NullBrunk/L3T/assets/125673909/5f2f5d09-5f43-4f88-a914-0beb7f21e110




### 👤 Profile


> [!NOTE]
> There is a profile page viewable by everyone that displays your won/drawn/lost games. You can watch a replay of a game by clicking on it in the "game history" section.

https://github.com/NullBrunk/L3T/assets/125673909/34c88f92-5a71-4fc4-a4f4-ff60364aa4db


### 📱 Responsive

> [!NOTE]
> All web pages have been designed to be responsive

https://github.com/NullBrunk/L3T/assets/125673909/48261adf-0760-405b-a9f4-ab905fcd627c



# 🤝 Thanks

- Thanks to <a href="https://uiverse.io/buttons">Universe.io</a> for the buttons, which inspired me in the realization of the **"play a game"** button.
- Thanks to <a href="https://codepen.io/Juxtopposed/pen/mdvaezM">Juxtopposed</a> for this landing page, which inspired me a lot.
- Thanks to <a href="https://codepen.io/tin-fung-hk/pen/MWrRqBw">tin-fung-hk</a> for those buttons, which inspired me for the profile page.
- Thanks to <a href="https://codepen.io/md-khokon/pen/bPLqzV">md-khokon</a> for the e-mail template. 
 



