import React from 'react';
import he from 'he';
 
import TextFilter from '../general/TextFilter';
import Api from 'Shared/Api';
import Icon from 'Shared/Icon';
import { __wprm } from 'Shared/Translations';

import '../../../css/admin/manage/taxonomies.scss';

export default {
    getColumns( datatable ) {
        let columns = [
            {
                Header: __wprm( 'Sort:' ),
                id: 'actions',
                headerClassName: 'wprm-admin-table-help-text',
                sortable: false,
                width: 65,
                Filter: () => (
                    <div>
                        { __wprm( 'Filter:' ) }
                    </div>
                ),
                Cell: row => (
                    <div className="wprm-admin-manage-actions">
                        <Icon
                            type="pencil"
                            title={ `${ __wprm( 'Rename' ) } ${ datatable.props.options.label.singular }` }
                            onClick={() => {
                                let newName = prompt( `${ __wprm( 'What do you want to be the new name for' ) } "${row.original.label}"?`, row.original.label );
                                if( newName && newName.trim() ) {
                                    Api.manage.renameTermLabel(datatable.props.options.id, row.original.term_id, newName).then(() => datatable.refreshData());
                                }
                            }}
                        />
                    </div>
                ),
            },{
                Header: __wprm( 'ID' ),
                id: 'id',
                accessor: 'term_id',
                width: 65,
                Filter: (props) => (<TextFilter {...props}/>),
            },{
                Header: __wprm( 'Diet' ),
                id: 'name',
                accessor: 'name',
                width: 150,
                Filter: (props) => (<TextFilter {...props}/>),
                Cell: row => row.value ? he.decode(row.value) : null,
            },{
                Header: __wprm( 'Label' ),
                id: 'label',
                accessor: 'label',
                sortable: false,
                filterable: false,
                Cell: row => row.value ? he.decode(row.value) : null,
            },{
                Header: __wprm( 'Recipes' ),
                id: 'count',
                accessor: 'count',
                filterable: false,
                width: 65,
            }
        ];
        return columns;
    }
};