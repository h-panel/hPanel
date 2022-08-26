
import tw from 'twin.macro';
import Can from '@/components/elements/Can';
import { ServerContext } from '@/state/server';
import CopyOnClick from '@/components/elements/CopyOnClick';
import TitledGreyBox from '@/components/elements/TitledGreyBox';
import FlashMessageRender from '@/components/FlashMessageRender';
import ServerContentBlock from '@/components/elements/ServerContentBlock';
import RenameServerBox from '@/components/server/settings/RenameServerBox';
import DeleteServerBox from '@/components/server/settings/DeleteServerBox';
import ReinstallServerBox from '@/components/server/settings/ReinstallServerBox';
import ChangeBackgroundBox from '@/components/server/settings/ChangeBackgroundBox';
import { Button } from '@/components/elements/button/index';
import Input from '@/components/elements/Input';
import Label from '@/components/elements/Label';
import { useStoreActions, useStoreState } from '@/state/hooks';
import React, { ChangeEvent, useEffect, useState } from 'react';
import { ip } from '@/lib/formatters';

export default () => {
    const uuid = ServerContext.useStoreState((state) => state.server.data!.uuid);
    const node = ServerContext.useStoreState((state) => state.server.data!.node);
    const sftp = ServerContext.useStoreState((state) => state.server.data!.sftpDetails);
    const id = ServerContext.useStoreState((state) => state.server.data!.id);
    const username = useStoreState((state) => state.user.data!.username);

    return (
        <ServerContentBlock title={'Settings'}>
            <FlashMessageRender byKey={'settings'} css={tw`mb-4`} />
            <h1 className={'j-left text-5xl'}>Settings</h1>
            <h3 className={'j-left text-2xl mt-2 text-neutral-500 mb-10'}>
                Control important settings for your server.
            </h3>
            <div className={'md:flex'}>
                <div className={'j-right w-full md:flex-1 md:mr-10'}>
                    <TitledGreyBox title={'Debug Information'} css={tw`mb-6 md:mb-10`}>
                        <div css={tw`flex items-center justify-between text-sm`}>
                            <p>Node</p>
                            <code css={tw`font-mono bg-neutral-900 rounded py-1 px-2`}>{node}</code>
                        </div>
                        <CopyOnClick text={uuid}>
                            <div css={tw`flex items-center justify-between mt-2 text-sm`}>
                                <p>Server ID</p>
                                <code css={tw`font-mono bg-neutral-900 rounded py-1 px-2`}>{uuid}</code>
                            </div>
                        </CopyOnClick>
                    </TitledGreyBox>
            <Can action={'file.sftp'}>
                <TitledGreyBox title={'SFTP Details'} className={'j-up mt-8 md:mt-6'}>
                    <div>
                        <Label>Server Address</Label>
                        <CopyOnClick text={`sftp://${ip(sftp.ip)}:${sftp.port}`}>
                            <Input type={'text'} value={`sftp://${ip(sftp.ip)}:${sftp.port}`} readOnly />
                        </CopyOnClick>
                    </div>
                    <div css={tw`mt-6`}>
                        <Label>Username</Label>
                        <CopyOnClick text={`${username}.${id}`}>
                            <Input type={'text'} value={`${username}.${id}`} readOnly />
                        </CopyOnClick>
                    </div>
                    <div css={tw`mt-6 flex items-center`}>
                        <div css={tw`flex-1`}>
                            <div css={tw`border-l-4 border-cyan-500 p-3`}>
                                <p css={tw`text-xs text-neutral-200`}>
                                    Your SFTP password is the same as the password you use to access this panel.
                                </p>
                            </div>
                        </div>
                        <div css={tw`ml-4`}>
                            <a href={`sftp://${username}.${id}@${ip(sftp.ip)}:${sftp.port}`}>
                                <Button.Text variant={Button.Variants.Secondary}>Launch SFTP</Button.Text>
                            </a>
                        </div>
                    </div>
                </TitledGreyBox>
            </Can>
                    <DeleteServerBox />
                    <ChangeBackgroundBox />
                </div>
                <div className={'j-left w-full mt-6 md:flex-1 md:mt-0'}>
                    <Can action={'settings.rename'}>
                        <div css={tw`mb-6 md:mb-10`}>
                            <RenameServerBox />
                        </div>
                    </Can>
                    <Can action={'settings.reinstall'}>
                        <ReinstallServerBox />
                    </Can>
                </div>
            </div>
        </ServerContentBlock>
    );
};
