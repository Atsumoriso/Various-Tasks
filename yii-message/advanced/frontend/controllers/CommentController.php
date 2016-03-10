<?php
namespace frontend\controllers;

use Yii;
use frontend\models\CommentForm;
use frontend\models\CommentUpdateForm;
use frontend\models\Comment;
use frontend\models\Country;
use yii\web\Controller;
use yii\db;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;




/**
 * Comment controller
 */
class CommentController extends Controller
{


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays page with form to add new message and shows all messages
     *
     * @return mixed
     */
    public function actionView()
    {
        /** Start Form */
        $formSubTitle = 'Add new comment';
        $commentForm = new commentForm();
        if($commentForm->load(Yii::$app->request->post()) && $commentForm->addComment() )
        {
            Yii::$app->session->setFlash('messageAdded');
            $this->redirect(
                Yii::$app->getUrlManager()->createUrl('comment/view')
            );

        }
        /** Start Comments list */
        $commentsOutputSubTitle = 'All comments';
        $comment = new Comment();
        $allComments = $comment->getAllComments();

        return $this->render('view', [
            'formSubTitle' => $formSubTitle,
            'commentsOutputSubTitle' => $commentsOutputSubTitle,
            'commentForm' => $commentForm,
            'allComments' => $allComments,

        ]);
    }


    /**
     * Archives one comment and renders comment/view
     */
    public function actionArchive()
    {
        $id = Yii::$app->request->get('id');
        $comment = new Comment();
        $comment->archiveComment($id);
        Yii::$app->session->setFlash('messageArchived');
        $this->redirect(
            Yii::$app->getUrlManager()->createUrl('/comment/view')
        );
    }

    /**
     * Displays page where one can edit comment chosen by id
     * @param $id
     * @return string
     */
    public function actionEdit($id)
    {
        $id = Yii::$app->request->get('id');
        // Checking if line with this id exists
        $check_id = Comment::find()->select(['comment_writer'])->where(['comment_id'=> $id])->one();

        if( $check_id != null){

            $comment = new Comment();
            $comment_to_update = $comment->findModel($id);
            $commentForm = new CommentUpdateForm($id, $comment_to_update);

            if($commentForm->load(Yii::$app->request->post()) && $commentForm->updateComment($id) )
                {
                    Yii::$app->session->setFlash('messageUpdated');
                    $this->redirect(
                        Yii::$app->getUrlManager()->createUrl('comment/view')
                    );

                } else
                {
                    return $this->render('edit', [
                        'commentForm' => $commentForm,
                    ]);
                }
        } else {
            $this->redirect(
                Yii::$app->getUrlManager()->createUrl('comment/view')
            );
        }

    }


}
