<?php
namespace AppBundle\Command\Tool;

use AppBundle\Command\Abstraction\Command;
use AppBundle\Entity\User;
use DateTime;
use FOS\UserBundle\Model\UserManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateSuperAdminCommand extends Command
{
    const OPTION_PASSWORD           = 'password';
    const OPTION_SHORT_PASSWORD     = 'p';

    const SUPER_ADMIN_USERNAME      = 'superadmin';
    const SUPER_ADMIN_EMAIL         = 'superadmin@example.com';
    const SUPER_ADMIN_FIRST_NAME    = self::SUPER_ADMIN_USERNAME;
    const SUPER_ADMIN_LAST_NAME     = self::SUPER_ADMIN_USERNAME;

    const SUPER_ADMIN_ROLE          = 'ROLE_SUPER_ADMIN';

    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('app:tool:create-super-admin')
            ->setDescription('Creates a Super Admin user if one does not exist or changes the existing Super Admin\'s password.')
            ->addOption(
                static::OPTION_PASSWORD,
                static::OPTION_SHORT_PASSWORD,
                InputOption::VALUE_REQUIRED,
                'Super Admin password.'
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $admin = $this->findSuperAdmin();

        if (!$admin instanceof User) {
            $admin = $this->createSuperAdmin();
        }

        $this->setSuperAdminPassword($admin, $input->getOption('password'));

        $this->saveSuperAdmin($admin);
    }

    /**
     * @return User
     */
    private function findSuperAdmin()
    {
        return $this->getUserManager()->findUserByUsername(static::SUPER_ADMIN_USERNAME);
    }

    /**
     * @return User
     */
    private function createSuperAdmin()
    {
        /** @var User $admin */
        $admin = $this->getUserManager()->createUser();

        $admin->setUsername(static::SUPER_ADMIN_USERNAME);
        $admin->setEmail(static::SUPER_ADMIN_EMAIL);
        $admin->setFirstName(static::SUPER_ADMIN_FIRST_NAME);
        $admin->setLastName(static::SUPER_ADMIN_FIRST_NAME);
        $admin->setDegree('');
        $admin->setDateOfBirth(new DateTime);
        $admin->addRole(static::SUPER_ADMIN_ROLE);
        $admin->setEnabled(true);

        return $admin;
    }

    /**
     * @param User $admin
     * @param string        $password
     */
    private function setSuperAdminPassword(User $admin, $password)
    {
        $admin->setPlainPassword($password);
    }

    /**
     * @param User $admin
     */
    private function saveSuperAdmin(User $admin)
    {
        $this->getUserManager()->updateUser($admin);
    }

    /**
     * @return UserManager
     */
    private function getUserManager()
    {
        return $this->getContainer()->get('fos_user.user_manager');
    }
}