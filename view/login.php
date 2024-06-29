<div class="main-container">
    <form action="" autocomplete="off" class="box login" method="post">
        <h5 class="title is-5 has-text-centered is-uppercase">
            Sistema de inventario
        </h5>

        <div class="field">
            <label class="label">Usuario</label>
            <div class="control">
                <input type="text" name="login_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" id="" class="input" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Clave</label>
            <div class="control">
                <input type="password" name="login_clave" required maxlength="100" id="" class="input" pattern="[a-zA-Z0-9$@.-]{7,100}">
            </div>
        </div>

        <p class="has-text-centered mb-4 mt-3">
            <button type="submit" class="button is-info is-rounded">
                Iniciar sesion
            </button>
        </p>

        <?php
        if (isset($_POST['login_usuario']) && isset($_POST['login_clave'])) {

            require_once './php/main.php';
            require_once './php/iniciar_sesion.php';
        }

        ?>

    </form>
</div>