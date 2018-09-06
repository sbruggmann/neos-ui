/* eslint-disable camelcase, react/jsx-pascal-case */
import React, {PureComponent} from 'react';
import PropTypes from 'prop-types';
import ListPreviewElement from '../ListPreviewElement/index';
import mergeClassNames from 'classnames';

class SelectBox_Option_SingleLine extends PureComponent {
    static propTypes = {
        option: PropTypes.shape({
            label: PropTypes.string.isRequired,
            icon: PropTypes.string,
            disabled: PropTypes.bool,
            secondary: PropTypes.bool
        }).isRequired,

        disabled: PropTypes.bool,

        className: PropTypes.string
    }

    render() {
        const {option, className, disabled, secondary} = this.props;

        const isDisabled = disabled || option.disabled;
        const isSecondary = secondary || option.secondary;

        const finalClassNames = mergeClassNames({
            [className]: className
        });

        return (
            <ListPreviewElement {...this.props} icon={option.icon} disabled={isDisabled} secondary={isSecondary} className={finalClassNames}>
                <span>{option.label}</span>
            </ListPreviewElement>
        );
    }
}

export default SelectBox_Option_SingleLine;
