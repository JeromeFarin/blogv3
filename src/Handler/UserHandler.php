<?php
namespace Application\Handler;

use Framework\Controller;
use Application\Manager\UserManager;
use Application\Model\User;
use Application\Form\UserForm;
use Zend\Diactoros\ServerRequest;
use Framework\FlashBag;

/**
 * Class UserHandler
 * @package Application\Handler
 */
class UserHandler extends Controller
{
    /**
     * @var UserManager
     */ 
    private $manager;

    /**
     * @var UserForm
     */
    public $form;

    /**
     * @var FlashBag
     */
    private $flash;

    /**
     * Constructor
     *
     * @param UserManager $manager
     * @param UserForm $form
     * @param FlashBag $flash
     */ 
    public function __construct(UserManager $manager, UserForm $form, FlashBag $flash) {
        $this->manager = $manager;
        $this->form = $form;
        $this->flash = $flash;
    }

    /**
     * Login
     *
     * @param ServerRequest $request
     * @return mixed
     */
    public function login(ServerRequest $request)
    {
        $this->form->handle($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            return $this->checkMail($this->form->getData());
        }
        
        return $this->flash->setFlash($this->form->getErrors());
    }

    /**
     * Check account with mail
     *
     * @param User $object
     * @return mixed
     */ 
    public function checkMail(User $object)
    {
        $check = $this->manager->check($object);
        if (!$check) {
            return $this->form->errors = array('mail' => 'No profiles found');
        } else {
            return $this->checkPass($object,$check);
        }
    }

    /**
     * Check pass
     *
     * @param User $object
     * @param User $check
     * @return mixed
     */
    private function checkPass(User $object,$check)
    {
        if (password_verify($object->getPass(),$check['pass'])) {
            $_SESSION['mail'] = $check['mail'];
            $_SESSION['pass'] = $object->getPass();
            return true;
        } else {
            return $this->form->errors = array('pass' => 'Bad password for this profile');
        }
    }

    /**
     * Logout
     *
     * @return mixed
     */
    public function logout()
    {
        return session_destroy();
    }

    /**
     * User list
     *
     * @return mixed
     */
    public function list()
    {
        return $this->manager->findAll();
    }

    /**
     * Create user
     *
     * @param ServerRequest $request
     * @return mixed
     */
    public function add(ServerRequest $request)
    {
        $this->form->handle($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->flash->setFlash(array('done' => 'User was created'));
            return $this->manager->insert($this->form->getData());
        }

        return $this->flash->setFlash($this->form->getErrors());
    }

    /**
     * Modify user
     *
     * @param ServerRequest $request
     * @return mixed
     */
    public function edit(ServerRequest $request)
    {        
        $this->form->handle($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->flash->setFlash(array('done' => 'User was modified'));
            return $this->manager->update($this->form->getData());
        }

        return $this->flash->setFlash($this->form->getErrors());
    }

    /**
     * Delete user
     *
     * @param ServerRequest $request
     * @return mixed
     */
    public function delete(ServerRequest $request)
    {
        $this->form->handle($request);

        if ($this->form->isSubmitted()) {
            $this->flash->setFlash(array('done' => 'User was deleted'));
            return $this->manager->delete($this->form->getData());
        }

        return $this->flash->setFlash($this->form->getErrors());
    }

    /**
     * Reset pass action
     *
     * @param ServerRequest $request
     * @return mixed
     */
    public function reset(ServerRequest $request)
    {
        $this->form->handle($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->flash->setFlash(array('done' => 'An mail has been sent'));
            return $this->sendResetPass($this->form->getData());
        }

        return $this->flash->setFlash($this->form->getErrors());
    }

    /**
     * Send mail for change pass
     *
     * @param User $object
     * @return mixed
     */
    private function sendResetPass(User $object)
    {
        $transport = (new \Swift_SmtpTransport(getenv("SWIFT_SMTP"), getenv("SWIFT_PORT"), getenv("SWIFT_TYPE")))->setUsername(getenv("SWIFT_USER"))->setPassword(getenv("SWIFT_PASS"));

        $mailer = new \Swift_Mailer($transport);

        $message = new \Swift_Message('Change password of Blog');
        $message->setFrom(array('blog@blog.com' => 'Support'));
        $message->setTo(array($object->getMail() => $object->getMail()));
        $message->setBody(
            $this->render('mail/mail_change_pass.twig', array(
                'title' => 'Change Password',
                'name' => $object->getUsername(),
                'id' => $object->getId(),
                'code' => $this->setCode($object)
            ),true),
            'text/html'
        );
        
        if ($mailer->send($message)) {
            return "An mail was send to ".$object->getMail();
        } else {
            return "An error was up, please contact administrator";
        }
    }

    /**
     * Set personal code and vilidty time
     *
     * @param User $object
     * @return mixed
     */
    private function setCode(User $object)
    {
        $code = substr(rand(),0,4);
        $codeValidity = time()+1800;

        $object->setCode(password_hash($code,PASSWORD_BCRYPT));
        $object->setCodeValidity($codeValidity);

        $this->manager->code($object);
        
        return $code;
    }

    /**
     * Change pass
     *
     * @param ServerRequest $request
     * @return mixed
     */
    public function passUpdate(ServerRequest $request)
    {
        $this->form->handle($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $oldUser = $this->manager->user($this->form->getData())[0];
            $newUser = $this->form->getData();
            
            if (password_verify($newUser->code,$oldUser->code)) {
                if ($oldUser->codevalidity >= time()) {
                    $newUser->setPass(password_hash($newUser->pass,PASSWORD_BCRYPT));
                    $newUser->setCode(null);
                    $newUser->setCodeValidity(null);
                    $this->flash->setFlash(array('done' => 'Password has been changed'));
                    return $this->manager->update($newUser);
                }
            }
        }

        return $this->flash->setFlash($this->form->getErrors());
    }
}
