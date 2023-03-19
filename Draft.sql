# ROLE EDIT DETAIL
CREATE VIEW view_permission_role AS
SELECT id, name, role_id
FROM permissions
         LEFT JOIN role_has_permissions ON permissions.id = role_has_permissions.permission_id;

# VIEW INDEX ROLE WITH 2 JOIN TABLE
CREATE VIEW view_index_permission_role AS
SELECT xs.role_id,r.name, GROUP_CONCAT(p.name) AS permission_name
FROM permissions p, roles r, role_has_permissions xs
WHERE xs.permission_id = p.id
  AND xs.role_id = r.id
GROUP BY xs.role_id;

# ASSIGN ROLE USER
CREATE VIEW view_assignRole_user AS
    SELECT x.id, p.name, x.name AS user_name
FROM users x, roles p ,model_has_roles y
WHERE y.model_id = x.id
AND y.role_id = p.id;

#ASSIGN PERMISSION USER
CREATE VIEW view_givePermission_user AS
SELECT x.id, p.name, x.name AS user_name
FROM users x, permissions p ,model_has_permissions y
WHERE y.model_id = x.id
  AND y.permission_id = p.id;
