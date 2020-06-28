import React, { Component, Fragment } from 'react';
import { Draggable } from 'react-beautiful-dnd';
import { isKeyHotkey } from 'is-hotkey';

const isTabHotkey = isKeyHotkey('tab');

import Icon from 'Shared/Icon';
import { __wprm } from 'Shared/Translations';

import FieldRichText from './FieldRichText';
import FieldText from './FieldText';
import FieldTextarea from './FieldTextarea';
import FieldVideoTime from './FieldVideoTime';
import Media from '../general/Media';

const handle = (provided) => (
    <div
        className="wprm-admin-modal-field-instruction-handle"
        {...provided.dragHandleProps}
        tabIndex="-1"
    ><Icon type="drag" /></div>
);

const group = (props, provided) => (
    <div
        className="wprm-admin-modal-field-instruction-group"
        ref={provided.innerRef}
        {...provided.draggableProps}
    >
        <div className="wprm-admin-modal-field-instruction-main-container">
            { handle(provided) }
            <div className="wprm-admin-modal-field-instruction-group-name-container">
                <FieldRichText
                    singleLine
                    toolbar="no-styling"
                    value={ props.name }
                    placeholder={ __wprm( 'Instruction Group Header' ) }
                    onChange={(value) => props.onChangeName(value)}
                    onKeyDown={(event) => {
                        if ( isTabHotkey(event) ) {
                            props.onTab(event);
                        }
                    }}
                />
            </div>
        </div>
        <div className="wprm-admin-modal-field-instruction-after-container">
            <div className="wprm-admin-modal-field-instruction-after-container-icons">
                <Icon
                    type="trash"
                    onClick={ props.onDelete }
                />
                <Icon
                    type="plus"
                    title={ __wprm( 'Insert After' ) }
                    onClick={ props.onAdd }
                />
            </div>
        </div>
    </div>
);

const instruction = (props, provided) => {
    let video = {
        type: 'none',
        embed: '',
        id: '',
        thumb: '',
        start: '',
        end: '',
        name: '',
    };

    if ( props.video ) {
        video = {
            ...video,
            ...props.video,
        };

        // For backwards compatibility.
        if ( 'none' === video.type && ( video.start || video.end ) ) {
            video.type = 'part';
        }
    }

    const hasImage = props.image > 0;

    return (
        <div
            className="wprm-admin-modal-field-instruction"
            ref={provided.innerRef}
            {...provided.draggableProps}
        >
            <div className="wprm-admin-modal-field-instruction-main-container">
                { handle(provided) }
                <div className="wprm-admin-modal-field-instruction-text-container">
                    <div className="wprm-admin-modal-field-instruction-text-name-container">
                        {
                            props.showName
                            &&
                            <FieldRichText
                                singleLine
                                className="wprm-admin-modal-field-instruction-name"
                                toolbar={ 'none' }
                                value={ props.hasOwnProperty( 'name' ) ? props.name : '' }
                                placeholder={ __wprm( 'Step Summary' ) }
                                onChange={(value) => props.onChangeName(value)}
                            />
                        }
                        <FieldRichText
                            className="wprm-admin-modal-field-instruction-text"
                            value={ props.text }
                            placeholder={ __wprm( 'This is one step of the instructions.' ) }
                            onChange={(value) => props.onChangeText(value)}
                            onKeyDown={(event) => {
                                if ( isTabHotkey(event) ) {
                                    props.onTab(event);
                                }
                            }}
                        />
                    </div>
                    {
                        props.allowVideo
                        && 'part' === video.type
                        &&
                        <div className="wprm-admin-modal-field-instruction-video-container">
                            <FieldVideoTime
                                value={ video.start }
                                onChange={ (start) => {
                                    props.onChangeVideo({
                                        ...video,
                                        start,
                                    });
                                }}
                            />
                            <FieldVideoTime
                                value={ video.end }
                                onChange={ (end) => {
                                    props.onChangeVideo({
                                        ...video,
                                        end,
                                    });
                                }}
                            />
                            {
                                video.start && video.end
                                ?
                                <FieldText
                                    placeholder={ __wprm( 'Name for this video part' ) }
                                    value={ video.name }
                                    onChange={ (name) => {
                                        props.onChangeVideo({
                                            ...video,
                                            name,
                                        });
                                    }}
                                />
                                :
                                <Icon
                                    type="movie"
                                    title={ __wprm( 'Add video start and end time (in seconds or minutes:seconds format) if this instruction step is part of the recipe video.' ) }
                                />
                            }
                        </div>
                    }
                </div>
            </div>
            <div className="wprm-admin-modal-field-instruction-after-container">
                <div className="wprm-admin-modal-field-instruction-after-container-icons">
                    <Icon
                        type="trash"
                        onClick={ props.onDelete }
                    />
                    <Icon
                        type="plus"
                        title={ __wprm( 'Insert After' ) }
                        onClick={ props.onAdd }
                    />
                </div>
                <div className="wprm-admin-modal-field-instruction-after-container-media">
                    <div className="wprm-admin-modal-field-instruction-after-container-media-icons">
                        <Icon
                            type="photo"
                            title={ hasImage ? __wprm( 'Remove Image' ) : __wprm( 'Add Instruction Image' ) }
                            onClick={ () => {
                                if ( hasImage ) {
                                    props.onChangeImage(0, '');
                                } else {
                                    Media.selectImage((attachment) => {
                                        props.onChangeImage(attachment.id, attachment.url);
                                    });
                                }
                            } }
                            hidden={ 'none' !== video.type && 'part' !== video.type }
                        />
                        <div className="wprm-icon-spacer"/>
                        <Icon
                            type="movie"
                            title={ 'upload' === video.type ? __wprm( 'Remove Video' ) : __wprm( 'Upload Instruction Video' ) }
                            onClick={ () => {
                                if ( 'upload' === video.type ) {
                                    props.onChangeVideo({
                                        ...video,
                                        type: 'none',
                                        id: 0,
                                        thumb: '',
                                    });
                                } else {
                                    Media.selectVideo((attachment) => {
                                        props.onChangeVideo({
                                            ...video,
                                            type: 'upload',
                                            id: attachment.attributes.id,
                                            thumb: attachment.attributes.thumb.src,
                                        });
                                    });
                                }
                            } }
                            hidden={ hasImage || ( 'none' !== video.type && 'upload' !== video.type ) }
                        />
                        <Icon
                            type="code"
                            title={ 'embed' === video.type ? __wprm( 'Remove Video' ) : __wprm( 'Embed Instruction Video' ) }
                            onClick={ () => {
                                if ( 'embed' === video.type ) {
                                    props.onChangeVideo({
                                        ...video,
                                        type: 'none',
                                        embed: '',
                                    });
                                } else {
                                    props.onChangeVideo({
                                        ...video,
                                        type: 'embed',
                                    });
                                }
                            } }
                            hidden={ hasImage || ( 'none' !== video.type && 'embed' !== video.type ) }
                        />
                        <Icon
                            type="videoplayer"
                            title={ 'part' === video.type ? __wprm( 'Remove Video Part' ) : __wprm( 'Instruction is part of the main video' ) }
                            onClick={ () => {
                                props.onChangeVideo({
                                    ...video,
                                    type: 'part' === video.type ? 'none' : 'part',
                                    start: '',
                                    end: '',
                                    name: '',
                                });
                            } }
                            hidden={ ! props.allowVideo || ( 'none' !== video.type && 'part' !== video.type ) }
                        />
                    </div>
                    {
                        ( hasImage || 'upload' === video.type || 'embed' === video.type )
                        &&
                        <div className="wprm-admin-modal-field-instruction-after-container-media-preview">
                            {
                                hasImage
                                ?
                                <div className="wprm-admin-modal-field-image-preview">
                                    <img
                                        src={ props.image_url }
                                        onClick={ () => {
                                            Media.selectImage((attachment) => {
                                                props.onChangeImage(attachment.id, attachment.url);
                                            });
                                        } }
                                    />
                                </div>
                                :
                                <Fragment>
                                    {
                                        'upload' === video.type
                                        &&
                                        <div className="wprm-admin-modal-field-video-preview">
                                            <img
                                                src={ video.thumb }
                                                onClick={ () => {
                                                    Media.selectVideo((attachment) => {
                                                        props.onChangeVideo({
                                                            ...video,
                                                            id: attachment.attributes.id,
                                                            thumb: attachment.attributes.thumb.src,
                                                        });
                                                    });
                                                } }
                                            />
                                        </div>
                                    }
                                    {
                                        'embed' === video.type
                                        &&
                                        <FieldTextarea
                                            value={ video.embed }
                                            onChange={(embed) => {
                                                props.onChangeVideo({
                                                    ...video,
                                                    embed,
                                                });
                                            }}
                                            placeholder={ __wprm( 'Instruction video URL or embed code' ) }
                                        />
                                    }
                                </Fragment>
                            }
                        </div>
                    }
                </div>
            </div>
        </div>
    )
};

export default class FieldInstruction extends Component {
    shouldComponentUpdate(nextProps) {
        return JSON.stringify(this.props) !== JSON.stringify(nextProps);
    }

    render() {
        return (
            <Draggable
                draggableId={ `instruction-${this.props.uid}` }
                index={ this.props.index }
            >
                {(provided, snapshot) => {
                    if ( 'group' === this.props.type ) {
                        return group(this.props, provided);
                    } else {
                        return instruction(this.props, provided);
                    }
                }}
            </Draggable>
        );
    }
}