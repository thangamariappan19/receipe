import React, { Component } from 'react';
import { DragDropContext, Droppable } from 'react-beautiful-dnd';

import '../../../../css/admin/modal/recipe/fields/instructions.scss';

import { __wprm } from 'Shared/Translations';
import Icon from 'Shared/Icon';
import FieldInstruction from '../../fields/FieldInstruction';

export default class RecipeInstructions extends Component {
    constructor(props) {
        super(props);

        this.state = {
            showName: false,
        }

        this.container = React.createRef();
        this.lastAddedIndex = 0;
    }

    shouldComponentUpdate(nextProps, nextState) {
        return this.state.showName !== nextState.showName || this.props.type !== nextProps.type || this.props.allowVideo !== nextProps.allowVideo || JSON.stringify( this.props.instructions ) !== JSON.stringify( nextProps.instructions );
    }

    componentDidUpdate( prevProps ) {
        if ( this.props.instructions.length > prevProps.instructions.length ) {
            const inputs = this.container.current.querySelectorAll('.wprm-admin-modal-field-richtext:not(.wprm-admin-modal-field-instruction-name)');

            if ( inputs.length ) {
                inputs[ this.lastAddedIndex ].focus();
            }
        }
    }

    onDragEnd(result) {
        if ( result.destination ) {
            let newFields = JSON.parse( JSON.stringify( this.props.instructions ) );
            const sourceIndex = result.source.index;
            const destinationIndex = result.destination.index;

            const field = newFields.splice(sourceIndex, 1)[0];
            newFields.splice(destinationIndex, 0, field);

            this.props.onRecipeChange({
                instructions_flat: newFields,
            });
        }
    }

    addField(type, afterIndex = false) {
        let newFields = JSON.parse( JSON.stringify( this.props.instructions ) );
        let newField;

        if ( 'group' === type ) {
            newField = {
                type: 'group',
                name: '',
            };
        } else {
            newField = {
                type: 'instruction',
                name: '',
                text: '',
                image: 0,
                image_url: '',
            }
        }

        // Give unique UID.
        let maxUid = Math.max.apply( Math, newFields.map( function(field) { return field.uid; } ) );
        maxUid = maxUid < 0 ? -1 : maxUid;
        newField.uid = maxUid + 1;

        if ( false === afterIndex ) {
            newFields.push(newField);
            this.lastAddedIndex = newFields.length - 1;
        } else {
            newFields.splice(afterIndex + 1, 0, newField);
            this.lastAddedIndex = afterIndex + 1;
        }

        this.props.onRecipeChange({
            instructions_flat: newFields,
        });
    }
  
    render() {
        return (
            <div
                className="wprm-admin-modal-field-instruction-container"
                ref={ this.container }
            >
                {
                    'ignore' !== wprm_admin.settings.metadata_instruction_name
                    && 'other' !== this.props.type
                    &&
                    <div className="wprm-admin-modal-field-instruction-show-name-container">
                        <input type="checkbox" id="wprm-admin-modal-field-instruction-show-name" checked={ this.state.showName } onChange={ (e) => this.setState({ showName: e.target.checked } ) } />
                        <label htmlFor="wprm-admin-modal-field-instruction-show-name">{ __wprm( 'Show the instruction summary field' ) }</label>
                        <Icon
                            type="question"
                            title={ __wprm( 'For guided recipes, Google wants a short (usually 1 word) summary for each instruction step. This will be the "name" in the HowToStep metadata.' ) }
                            className="wprm-admin-icon-help"
                        />
                    </div>
                }
                <DragDropContext
                    onDragEnd={this.onDragEnd.bind(this)}
                >
                    <Droppable
                        droppableId="wprm-instructions"
                    >
                        {(provided, snapshot) => (
                            <div
                                className={`${ snapshot.isDraggingOver ? ' wprm-admin-modal-field-instruction-container-draggingover' : ''}`}
                                ref={provided.innerRef}
                                {...provided.droppableProps}
                            >
                                {
                                    this.props.instructions.map((field, index) => (
                                        <FieldInstruction
                                            { ...field }
                                            index={ index }
                                            key={ `instruction-${field.uid}` }
                                            onTab={(event) => {
                                                // Create new instruction if we're tabbing in the last one.
                                                if ( index === this.props.instructions.length - 1) {
                                                    event.preventDefault();
                                                    // Use timeout to fix focus problem (because of preventDefault?).
                                                    setTimeout(() => {
                                                        this.addField( 'instruction' );
                                                    });
                                                }
                                            }}
                                            showName={ this.state.showName }
                                            onChangeName={ ( name ) => {
                                                let newFields = JSON.parse( JSON.stringify( this.props.instructions ) );
                                                newFields[index].name = name;
                                                
                                                this.props.onRecipeChange({
                                                    instructions_flat: newFields,
                                                });
                                            }}
                                            onChangeText={ ( text ) => {
                                                let newFields = JSON.parse( JSON.stringify( this.props.instructions ) );
                                                newFields[index].text = text;

                                                this.props.onRecipeChange({
                                                    instructions_flat: newFields,
                                                });
                                            }}
                                            onChangeImage={ ( image, url ) => {
                                                let newFields = JSON.parse( JSON.stringify( this.props.instructions ) );

                                                newFields[index].image = image;
                                                newFields[index].image_url = url;
                                                
                                                this.props.onRecipeChange({
                                                    instructions_flat: newFields,
                                                });
                                            }}
                                            onDelete={() => {
                                                let newFields = JSON.parse( JSON.stringify( this.props.instructions ) );
                                                newFields.splice(index, 1);

                                                this.props.onRecipeChange({
                                                    instructions_flat: newFields,
                                                });
                                            }}
                                            onAdd={() => {
                                                this.addField('instruction', index);
                                            }}
                                            allowVideo={ this.props.allowVideo }
                                            onChangeVideo={ ( video ) => {
                                                let newFields = JSON.parse( JSON.stringify( this.props.instructions ) );
                                                newFields[index].video = video;
                                                
                                                this.props.onRecipeChange({
                                                    instructions_flat: newFields,
                                                });
                                            }}
                                        />
                                    ))
                                }
                                {provided.placeholder}
                            </div>
                        )}
                    </Droppable>
                </DragDropContext>
                <div
                    className="wprm-admin-modal-field-instruction-actions"
                >
                    <button
                        className="button"
                        onClick={(e) => {
                            e.preventDefault();
                            this.addField( 'instruction' );
                        } }
                    >{ __wprm( 'Add Instruction' ) }</button>
                    <button
                        className="button"
                        onClick={(e) => {
                            e.preventDefault();
                            this.addField( 'group' );
                        } }
                    >{ __wprm( 'Add Instruction Group' ) }</button>
                    <p>{ __wprm( 'Tip: use the TAB key to move from field to field and easily add instructions.' ) }</p>
                </div>
            </div>
        );
    }
}
