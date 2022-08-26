import React from 'react';
import tw from 'twin.macro';
import Fade from '@/components/elements/Fade';
import Select from '@/components/elements/Select';
import Spinner from '@/components/elements/Spinner';
import styled, { css } from 'styled-components/macro';

const Container = styled.div<{ visible?: boolean }>`
    ${tw`relative`};

    ${(props) =>
        props.visible &&
        css`
            & ${Select} {
                background-image: none;
            }
        `};
`;

const InputSpinner = ({ visible, children }: { visible: boolean; children: React.ReactNode }) => (
    <Container visible={visible}>
        <Fade appear unmountOnExit in={visible} timeout={150}>
            <div css={tw`absolute right-0 h-full flex items-center justify-end pr-3`}>
                <Spinner size={'small'} />
            </div>
        </Fade>
        {children}
    </Container>
);

export default InputSpinner;
