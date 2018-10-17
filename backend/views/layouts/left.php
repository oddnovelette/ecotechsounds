<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username ?></p>
                <p><?= Yii::$app->request->userIP ?></p>
            </div>
            <div class="clearfix"></div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    ['label' => 'Management', 'options' => ['class' => 'header']],

                    ['label' => 'Store', 'icon' => 'folder', 'items' => [
                        ['label' => 'Products', 'icon' => 'file-o', 'url' => ['/store/product/index'], 'active' => $this->context->id == 'store/product'],
                        ['label' => 'Tags', 'icon' => 'file-o', 'url' => ['/store/tag/index'], 'active' => $this->context->id == 'store/tag'],
                        ['label' => 'Categories', 'icon' => 'file-o', 'url' => ['/store/category/index'], 'active' => $this->context->id == 'store/category'],
                        ['label' => 'Labels', 'icon' => 'file-o', 'url' => ['/store/label/index'], 'active' => $this->context->id == 'store/label'],
                    ]],

                    ['label' => 'Users', 'icon' => 'user', 'url' => ['/user/index'], 'active' => $this->context->id == 'user/index'],
                ],
            ]
        ) ?>

    </section>

</aside>
