-- see related Thing->actions->properties
select T.id thing_id , A.id action_id, T.brand, T.name Tname, A.name Aname, P.value Pvalue from thing T, action A, property P where T.id = A.id_thing_id AND P.id_action_id = A.id;



select T.id, T.brand, T.name, U.name, U.password, A.name action_name  from thing T, user U, action A where T.id = U.thing_id and T.id = A.id_thing_id;

