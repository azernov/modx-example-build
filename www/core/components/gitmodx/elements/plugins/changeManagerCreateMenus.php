<?php
/**
 * Плагин, убирающий из меню ресурса определенные пункты меню "Создать"
 * TODO поправьте в javascript логику в зависимости от своего проекта
 */

switch ($modx->event->name) {
    case 'OnManagerPageInit':

    $JS = <<<HTML
<script type="text/javascript">
Ext.onReady(function(){
    // Получаем дерево
    var tree = Ext.getCmp('modx-resource-tree');
    // Описываем правила разрешенных дочерних ресурсов
    var resourcesRules = {
        msProduct: ['modDocument'],
        msCategory: ['msProduct','msCategory'],
    };
    // Прописываем функцию копирования значений объекта,
    // так как у нас проблемы на уровне ссылок на объекты,
    // то есть изменяя одну переменную, изменяется и другая, если объект общий
    var copyObject = function(from){
        var to = {};
        for(i in from){
            to[i] = from[i];
        }
        return to;
    };
    // Фиксируем изначальный набор классов
    var classes = copyObject(MODx.config.resource_classes);
    // Навешиваем функцию изменения набора классов
    // при создании контекстного меню
    tree.on('loadCreateMenus', function(types){
        var node = this.cm.activeNode;
        var classKey;
        if(resourcesRules && node && node.attributes 
                && (classKey = node.attributes.classKey)
                && resourcesRules[classKey]
        ){
            for(var i in types){
                if(!resourcesRules[classKey].in_array(i)){
                    delete  types[i];
                }
            }
        }    
        return true;
    }, tree);
    
    // Навешиваем функцию восстановления набора классов
    // Эта функция выполнится после формирования меню, так как навешено позже
    // базового метода дерева ресурсов
    tree.on('contextmenu', function(){
        MODx.config.resource_classes = copyObject(classes);
    });
});
</script>
HTML;
        $modx->regClientStartupScript($JS, true);
        break;
}