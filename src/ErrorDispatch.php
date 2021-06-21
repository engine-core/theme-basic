<?php
/**
 * @link https://github.com/engine-core/theme-basic
 * @copyright Copyright (c) 2021 engine-core
 * @license BSD 3-Clause License
 */

declare(strict_types=1);

namespace EngineCore\themes\Basic;

use EngineCore\dispatch\Dispatch;
use Yii;
use yii\base\Exception;
use yii\base\UserException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * 错误控制器
 *
 * @see \yii\web\ErrorAction
 */
class ErrorDispatch extends Dispatch
{

    /**
     * @var integer 等待多久自动跳转到指定页面
     */
    public $waitSecond = 3;

    /**
     * @var string the view file to be rendered. If not set, it will take the value of [[id]].
     * That means, if you name the action as "error" in "SiteController", then the view name
     * would be "error", and the corresponding view file would be "views/site/error.php".
     * @see \yii\web\ErrorAction::$view
     */
    public $view;

    /**
     * @var string the message to be displayed when the exception message contains sensitive information.
     * Defaults to "An internal server error occurred.".
     * @see \yii\web\ErrorAction::$defaultMessage
     */
    public $defaultMessage;

    /**
     * @var string the name of the error when the exception name cannot be determined.
     * Defaults to "Error".
     * @see \yii\web\ErrorAction::$defaultName
     */
    public $defaultName;

    /**
     * @var \Exception the exception object, normally is filled on [[init()]] method call.
     * @see [[findException()]] to know default way of obtaining exception.
     * @see \yii\web\ErrorAction::$exception
     */
    protected $exception;

    /**
     * @var string|false|null the name of the layout to be applied to this error action view.
     * If not set, the layout configured in the controller will be used.
     * @see \yii\base\Controller::$layout
     * @see \yii\web\ErrorAction::$layout
     */
    public $layout;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->exception = $this->findException();

        if ($this->defaultMessage === null) {
            $this->defaultMessage = Yii::t('ec/app', 'An internal server error occurred.');
        }

        if ($this->defaultName === null) {
            $this->defaultName = Yii::t('ec/app', 'Error');
        }
    }

    /**
     * @see \yii\web\ErrorAction::run
     */
    public function run()
    {
        if ($this->layout !== null) {
            $this->controller->layout = $this->layout;
        }

        Yii::$app->getResponse()->setStatusCodeByException($this->exception);

        if (Yii::$app->getRequest()->getIsAjax()) {
            return $this->renderAjaxResponse();
        } else {
            return $this->renderHtmlResponse();
        }
    }

    /**
     * Builds string that represents the exception.
     * Normally used to generate a response to AJAX request.
     * @return Response
     * @see \yii\web\ErrorAction::renderAjaxResponse
     */
    protected function renderAjaxResponse()
    {
        return $this->response
            ->setWaitSecond($this->waitSecond)
            ->setJumpUrl('')
            ->error($this->getExceptionName() . ': ' . $this->getExceptionMessage());
    }

    /**
     * Renders a view that represents the exception.
     * @return string
     */
    protected function renderHtmlResponse()
    {
        $this->response
            ->setAssign($this->getViewRenderParams())
            ->setWaitSecond($this->waitSecond)
            ->setJumpUrl("javascript:history.back(-1);");

        return $this->response->render($this->view);
    }

    /**
     * Builds array of parameters that will be passed to the view.
     * @return array
     * @see \yii\web\ErrorAction::getViewRenderParams
     */
    protected function getViewRenderParams()
    {
        return [
            'name' => $this->getExceptionName(),
            'message' => $this->getExceptionMessage(),
            'exception' => $this->exception,
        ];
    }

    /**
     * 异常处理器未获取到则自动赋值为[[\yii\web\NotFoundHttpException]]
     *
     * @return \Exception
     * @see \yii\web\ErrorAction::findException
     */
    protected function findException()
    {
        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            $exception = new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        return $exception;
    }

    /**
     * Gets the code from the [[exception]].
     * @return mixed
     * @see \yii\web\ErrorAction::getExceptionCode
     */
    protected function getExceptionCode()
    {
        if ($this->exception instanceof HttpException) {
            return $this->exception->statusCode;
        }

        return $this->exception->getCode();
    }

    /**
     * Returns the exception name, followed by the code (if present).
     *
     * @return string
     * @see \yii\web\ErrorAction::getExceptionName
     */
    protected function getExceptionName()
    {
        if ($this->exception instanceof Exception) {
            $name = $this->exception->getName();
        } else {
            $name = $this->defaultName;
        }

        if ($code = $this->getExceptionCode()) {
            $name .= " (#$code)";
        }

        return $name;
    }

    /**
     * 异常显示消息
     * 异常由[[\yii\base\UserException]]触发，则获取用户自定义的异常消息，如果消息为空，则返回默认[[$defaultMessage]]消息。
     *
     * @return string
     * @see \yii\web\ErrorAction::getExceptionMessage
     */
    protected function getExceptionMessage()
    {
        if ($this->exception instanceof UserException) {
            return $this->exception->getMessage() ?: $this->defaultMessage;
        }

        return $this->defaultMessage;
    }

}