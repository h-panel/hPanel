import tw from 'twin.macro';
import { debounce } from 'debounce';
import { ip } from '@/lib/formatters';
import * as Icon from 'react-feather';
import isEqual from 'react-fast-compare';
import Can from '@/components/elements/Can';
import styled from 'styled-components/macro';
import Code from '@/components/elements/Code';
import { ServerContext } from '@/state/server';
import { useFlashKey } from '@/plugins/useFlash';
import { Allocation } from '@/api/server/getServer';
import { Textarea } from '@/components/elements/Input';
import GreyRowBox from '@/components/elements/GreyRowBox';
import React, { memo, useCallback, useState } from 'react';
import { Button } from '@/components/elements/button/index';
import CopyOnClick from '@/components/elements/CopyOnClick';
import InputSpinner from '@/components/elements/InputSpinner';
import getServerAllocations from '@/api/swr/getServerAllocations';
import setServerAllocationNotes from '@/api/server/network/setServerAllocationNotes';
import DeleteAllocationButton from '@/components/server/network/DeleteAllocationButton';
import setPrimaryServerAllocation from '@/api/server/network/setPrimaryServerAllocation';

const Label = styled.label`
    ${tw`uppercase text-xs mt-1 text-neutral-400 block px-1 select-none transition-colors duration-150`}
`;

interface Props {
    allocation: Allocation;
}

const AllocationRow = ({ allocation }: Props) => {
    const [loading, setLoading] = useState(false);
    const { clearFlashes, clearAndAddHttpError } = useFlashKey('server:network');
    const uuid = ServerContext.useStoreState((state) => state.server.data!.uuid);
    const { mutate } = getServerAllocations();

    const onNotesChanged = useCallback((id: number, notes: string) => {
        mutate((data) => data?.map((a) => (a.id === id ? { ...a, notes } : a)), false);
    }, []);

    const setAllocationNotes = debounce((notes: string) => {
        setLoading(true);
        clearFlashes();

        setServerAllocationNotes(uuid, allocation.id, notes)
            .then(() => onNotesChanged(allocation.id, notes))
            .catch((error) => clearAndAddHttpError(error))
            .then(() => setLoading(false));
    }, 750);

    const setPrimaryAllocation = () => {
        clearFlashes();
        mutate((data) => data?.map((a) => ({ ...a, isDefault: a.id === allocation.id })), false);

        setPrimaryServerAllocation(uuid, allocation.id).catch((error) => {
            clearAndAddHttpError(error);
            mutate();
        });
    };

    return (
        <GreyRowBox $hoverable={false} className={'j-up flex-wrap md:flex-nowrap mt-2'}>
            <div className={'flex items-center w-full md:w-auto'}>
                <div className={'pl-4 pr-6 text-neutral-400'}>
                    <Icon.Share2 />
                </div>
                <div className={'mr-4 flex-1 md:w-40'}>
                    {allocation.alias ? (
                        <CopyOnClick text={allocation.alias}>
                            <Code dark className={'w-40 truncate'}>
                                {allocation.alias}
                            </Code>
                        </CopyOnClick>
                    ) : (
                        <CopyOnClick text={ip(allocation.ip)}>
                            <Code dark>{ip(allocation.ip)}</Code>
                        </CopyOnClick>
                    )}
                    <Label>{allocation.alias ? 'Hostname' : 'IP Address'}</Label>
                </div>
                <div className={'w-16 md:w-24 overflow-hidden'}>
                    <Code dark>{allocation.port}</Code>
                    <Label>Port</Label>
                </div>
            </div>
            <div className={'mt-4 w-full md:mt-0 md:flex-1 md:w-auto'}>
                <InputSpinner visible={loading}>
                    <Textarea
                        className={'bg-neutral-800 hover:border-neutral-600 border-transparent'}
                        placeholder={'Notes'}
                        defaultValue={allocation.notes || undefined}
                        onChange={(e) => setAllocationNotes(e.currentTarget.value)}
                    />
                </InputSpinner>
            </div>
            <div className={'flex justify-end space-x-4 mt-4 w-full md:mt-0 md:w-48'}>
                {allocation.isDefault ? (
                    <Button size={Button.Sizes.Small} className={'!text-gray-50 !bg-blue-600'} disabled>
                        Primary
                    </Button>
                ) : (
                    <>
                        <Can action={'allocation.delete'}>
                            <DeleteAllocationButton allocation={allocation.id} />
                        </Can>
                        <Can action={'allocation.update'}>
                            <Button.Text size={Button.Sizes.Small} onClick={setPrimaryAllocation}>
                                Make Primary
                            </Button.Text>
                        </Can>
                    </>
                )}
            </div>
        </GreyRowBox>
    );
};

export default memo(AllocationRow, isEqual);
