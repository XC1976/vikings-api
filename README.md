# Description
- CHAN Kyle
- DE LA GENIERE Clement
- HADDAD Thinina

The main tasks and the bonuses are included. The way API calls have to be formed can be easily deduced using the postman export, it is using $_GET['id'] AND/OR body json parameters.

The vikings.sql is not a PHPMyAdmin export but a manually typed .sql intended to be ran as is.

There is only a single commit because of issues encountered with the original private repository.

## Organization

Since the PHP pages are often independent of each other in term of development, the repartition of tasks was task based for each member of the group.

## Bonus

The deletion behavior was done simply by specifying this SQL constrait : `FOREIGN KEY(weaponID) REFERENCES Weapon(id) ON DELETE SET NULL`

# Known problems
All the verifications asked by the guidelines and some additional one were written (e.g. error message for SQL Update where no values are changed). But not all cases are convered.

- It was asked to name "weapon" but it is here often named as "Weapon" such as /api/Weapon/
- In certain cases, the error handling will not work if the body is completely empty since there is no error handling on $data = getBody() itself. In this case, the $_GET['id'] and the body json parameters error handling will not work and it will simply fail without an error message.
- GET /viking/findByWeapon.php?id=<weaponId> does not have a lot of error handling if at all. It only works as is.