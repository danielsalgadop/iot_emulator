-- see related Thing->actions->properties
select T.id thing_id , A.id action_id, T.brand, T.name Tname, A.name Aname, P.value Pvalue from thing T, action A, property P where T.id = A.id_thing_id AND P.id_action_id = A.id;

