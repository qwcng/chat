<script>
function useTheme(background, colors) {
    let body = document.querySelector('body');

    document.body.style.background = `url('themes/${background}') no-repeat center center / cover`;
    document.documentElement.style.setProperty('--outcoming', colors[1])
    document.documentElement.style.setProperty('--inputs', colors[1])
    document.documentElement.style.setProperty('--incoming', colors[0])

    // document.documentElement.style.setProperty('--background', `url(/themes/${background})`);
}

function customTheme(background) {
    let body = document.querySelector('body');
    document.body.style.background = `url('${background}') no-repeat center center / cover`;
    // document.documentElement.style.setProperty('--background', `url(/themes/${background})`);
}

function themes() {
    let currentTheme = 0;
    let themes = [];
    let submit = document.querySelector('.saveTheme');
    let themeInput = document.getElementById('hiddenTheme');
    let form = document.getElementById('theme');
    let themeName = [];
    let themeLabel = document.querySelector('.label');
    let file = document.querySelector('.file');
    let colors = []
    let id = []
    let themeId = document.querySelector('.themeId');
    let left = document.querySelector('.left');
    let right = document.querySelector('.right');
    file.style.display = 'flex';
    <?php 
            $themes = $chat->getAllThemes();
            foreach ($themes as $theme): ?>
    id.push(<?= $theme['id']?>)
    themes.push("<?= $theme['background']; ?>");
    themeName.push("<?= $theme['name']; ?>");
    colors.push(<?= $theme['colors']?>)
    <?php endforeach; ?>


    let changeTheme = document.querySelector('.theme');
    left.onlclick = () => {
        currentTheme--;
        if (currentTheme < 0) {
            currentTheme = themes.length - 1;
            themeLabel.innerHTML = themeName[currentTheme];
        }


    }
    right.onclick = () => {
        currentTheme++;
        if (currentTheme >= themes.length) {
            currentTheme = 0;
            themeLabel.innerHTML = themeName[currentTheme];
        }

    }

    changeTheme.onclick = () => {

        submit.style.display = 'block';
        submit.onclick = () => {

        };

        themeLabel.innerHTML = themeName[currentTheme];


        useTheme(themes[currentTheme], colors[currentTheme]);
        themeInput.value = id[currentTheme];

        currentTheme++;
        if (currentTheme >= themes.length) {
            currentTheme = 0;
        }




        form.onsubmit = (e) => {
            e.preventDefault();
            console.log(new FormData(form));
            quickXHR("xhr/set_theme.php", "POST", new FormData(form), "Successfully added theme");
        };
    };
}

function addTheme() {
    quickXHR("xhr/add_theme.php", "POST", document.getElementById("addTheme"), "Succesfully added theme");
}
</script>