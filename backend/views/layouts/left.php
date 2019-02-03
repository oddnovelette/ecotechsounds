<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="https://t4.ftcdn.net/jpg/02/06/12/43/160_F_206124303_p6rm6135nqCP5bUhyuOCseKwfnNEGG8w.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>
                    <?= Yii::$app->request->userIP ?></p>
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
                    ['label' => 'Magazine', 'icon' => 'folder', 'items' => [
                        ['label' => 'Posts', 'icon' => 'file-o', 'url' => ['/blog/post/index'], 'active' => $this->context->id == 'blog/post'],
                        ['label' => 'Comments', 'icon' => 'file-o', 'url' => ['/blog/comment/index'], 'active' => $this->context->id == 'blog/comment'],
                        ['label' => 'Categories', 'icon' => 'file-o', 'url' => ['/blog/category/index'], 'active' => $this->context->id == 'blog/category'],
                        ['label' => 'Tags', 'icon' => 'file-o', 'url' => ['/blog/tag/index'], 'active' => $this->context->id == 'blog/tag'],
                    ]],

                    ['label' => 'Pages', 'icon' => 'file-text', 'url' => ['/page/index'], 'active' => $this->context->id == 'page'],
                    ['label' => 'Users', 'icon' => 'user', 'url' => ['/user/index'], 'active' => $this->context->id == 'user/index'],
                    ['label' => 'Files', 'icon' => 'files-o', 'url' => ['/file/index'], 'active' => $this->context->id == 'file'],
                ],
            ]
        ) ?>

        <?= yii\helpers\Html::a(
            'Sign out',
            ['/site/logout'],
            ['data-method' => 'post']
        ) ?>

    </section>

</aside>
