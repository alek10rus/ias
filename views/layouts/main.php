<?php

	/* @var $this \yii\web\View */
	/* @var $content string */

	use yii\helpers\Html;
	use yii\bootstrap\Nav;
	use yii\bootstrap\NavBar;
	use yii\widgets\Breadcrumbs;
	use app\assets\AppAsset;

	AppAsset::register($this);
?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

	<head>
		<meta charset="<?= Yii::$app->charset ?>"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<meta name = "Content-language" content = "ru"/>
		<?= Html::csrfMetaTags() ?>
		<title id="1"><?= Html::encode($this->title) ?></title>
		<?php $this->head() ?>
	</head>

	<body>
		<?php $this->beginBody() ?>
			<!--
				* ШАПКА
				* Стиль задан
			-->
			<div id = "header">
				<!--
					* ЛЕВАЯ ЧАСТЬ ШАПКИ
					* Логотип ПетрГУ
					* Стиль задан
				-->
				<div id = "header_left">
					<img src = "../../img/petrsu.png" style = "height: 10vw;" />
				</div>
				<!--
					* ЦЕТРАЛЬНАЯ ЧАСТЬ ШАПКИ
					* Название сайта
					* Стиль задан
				-->
				<div id  ="header_center">
					ИНФОРМАЦИОННО-АНАЛИТИЧЕСКАЯ СИСТЕМА 
					</br>
					ВЫБОРА ЭЛЕКТИВНЫХ И ФАКУЛЬТАТИВНЫХ ДИСЦИПЛИН 
					</br>
					СТУДЕНТАМИ ФМИТ
					<!--
						* ИМЯ ПОЛЬЗОВАТЕЛЯ
						* Стиль задан
						*
						* При входе в систему отражается имя и фамилия пользователя
						* При нажатии на имя пользователя происходит выход из системы
					-->
					
						<?php if (!Yii::$app->user->isGuest):?>
						<?=Html::beginForm(['/site/logout'], 'post', ['id' => 'user']).
					 		Html::submitButton(
                    		Yii::$app->user->identity->name.' '.Yii::$app->user->identity->surname,
                    		['class' => 'btn btn-link',
                    		'data' => ['confirm' => 'Вы действительно хотите выйти?'],
							])
     					. Html::endForm() ?>
						<?php else: ?>
						<div id="user">
							<?= Html::a(Войти, '/site/login',['class'=>'btn btn-link'])?>
						</div>
						<?php endif ?>
					
				</div>
				<!--
					* ПРАВАЯ ЧАСТЬ ШАПКИ
					* Логотип ФМИТ
					* Стиль задан
				-->
				<div id = "header_right">
					<img src = "../../img/math.png" style = "height: 10vw;" />
				</div>	
			</div>
			<!-- КОНЕЦ ШАПКИ -->
			
			<!--
				* МЕНЮ
				* Стиль задан
			-->
			<div id = "premenu" >
				<div id = "menu" > 
					<div class = "main_menu">       <?= Html::a(Главная, '/site/index')?>
					</div>         
					<div class = "disciplines_menu"><?= Html::a(Дисциплины , '/discipline/list')?></div>
					<div class = "new_menu">        <?= Html::a(Объявления  , '/news/list')?></div>
				</div>
			</div>
			<!-- КОНЕЦ МЕНЮ -->

			<!--
			  * СОДЕРЖИМОЕ СТРАНИЦЫ
			  * генерируется в зависимости от страницы
			  * Первичный стиль задан. Дополнительные настройки стиля будут добавляться в зависимости от страницы
			  -->
			<div id = "precontent">
				<div id = "content">
					
					<?= $content ?>
				</div>
			</div>
			
			<div class ="clear"></div>	
			<!--
				* ПОДВАЛ
				* Стиль задан
			-->
			<div id = "prefooter">
				<div id = "footer">
					<?= Html::a("Связаться с администратором", '/site/contact',['class'=>'btn btn-link'])?>
				</div>
			</div>
			<!-- Старое оформление подвала
				<footer class="footer">
					<div class="container">
						<p class="pull-left">&copy; My Company <?= date('Y') ?></p>
						<p class="pull-right"><?= Yii::powered() ?></p>
					</div>
				</footer>
			-->
		<?php $this->endBody() ?>
	</body>

</html>

<?php $this->endPage() ?>
